<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Destination;
use App\Models\Order;
use App\Models\Routee;
use App\Models\Trip;
use Brian2694\Toastr\Facades\Toastr;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Barryvdh\DomPDF\Facade\Pdf;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Destination::all();
        return view('frontend.home', compact('data'));
    }

    public function trip(Request $request, $id)
    {
        $date = $request->input('date');
        $trip = Trip::where('id', $id)->with('vehicles', 'schedules', 'routes', 'types')->first();
        $order = Order::where('trip_id', $trip->id)
            ->where('date', $date)
            ->get()
            ?? [];
        return view('frontend.load.seat', compact('trip', 'date', 'order'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        Session::forget('seat');
        $from = $request->input('from');
        $to = $request->input('to');
        $date = $request->input('date');
        if (date('Y-m-d') <= $request->input('date')) {
            $data = Destination::all();
            $route = Routee::where('from', $from)->where('to', $to)->first();
            if ($route) {
                $trip = Trip::where('route_id', $route->id)->with('vehicles', 'schedules', 'routes', 'types')->get();
                return view('frontend.search', compact('data', 'from', 'to', 'date', 'trip'));
            }
            Toastr::error('No bus found for selected dates or cities');
            return redirect()->back();
        }
        Toastr::error('No bus found for selected dates');
        return redirect()->back();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function seatCount(Request $request)
    {
        $seat = \session()->get('seat') ?? [];
        if (key_exists($request->seat, $seat)) {
            foreach ($seat as $key => $item) {
                if ($item['seat'] == $request->seat) {
                    unset($seat[$key]);
                }
            }
            session(['seat' => $seat]);
            return 'remove';
        } else {
            if (count($seat) < 4) {
                $seat[$request->seat] = [
                    'seat' => $request->seat,
                    'id' => $request->id,
                    'price' => $request->price,
                ];
                \session(['seat' => $seat]);
                return $seat;
            }
            return response()->json([
                'message' => 'You can select maximum 4 seat'
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function invoice()
    {
        return view('frontend.invoice');
    }

    public function numberSearch(Request $request)
    {
        $query = $request->input('query');
        $data = Order::where('number', 'LIKE', "%{$query}%")->limit(10)->get();
        return view('frontend.load.list', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function download($id)
    {
        $show['data'] = Order::findorfail($id);
        $pdf = PDF::loadView('frontend.invoice', $show);
        return $pdf->setPaper('a4', 'landscape')->setWarnings(false)->download('ticked.pdf');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function order(Request $request)
    {
        // return $request;
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required',
                'number' => 'required',
                'gender' => 'required',
                'method' => 'required',
                'seat' => 'required',
            ],
            [
                'seat.required' => 'Please select your seat'
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()->withErrors(Toastr::error($validator->errors()->all()[0]))->withInput();
        }

        try {
            $data = Order::create([
                'trip_id' => $request->input('trip_id'),
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'number' => $request->input('number'),
                'gender' => $request->input('gender'),
                'method' => $request->input('method'),
                'transaction' => uniqid(),
                'ticked_no' => strtoupper(uniqid()),
                'date' => $request->input('date'),
                'price' => $request->input('price'),
                'seat' => $request->input('seat'),
                'time' => $request->input('time'),
                'status' => 'complete'
            ]);
            Session::forget('seat');
            Toastr::success('Ticked booking successful!!');
            $trip = Trip::with('routes', 'types')->findOrFail($request->input('trip_id'));
            return view('frontend.invoice', compact('data','trip'));
        } catch (Exception $error) {
            Toastr::error($error->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        Session::forget('seat');
    }
}
