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
        return view('frontend.load.seat', compact('trip','date'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $from = $request->input('from');
        $to = $request->input('to');
        $date = $request->input('date');
        if (date('Y-m-d') <= $request->input('date')) {
            $data = Destination::all();
            $route = Routee::where('from', $from)->where('to', $to)->first();
            if ($route) {
                $trip = Trip::where('route_id', $route->id)->with('vehicles', 'schedules', 'routes', 'types')->get();
                // return $trip;
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
        $seat = \session()->has('seat') ? \session()->get('seat') : [];
        if (key_exists($request->seat, $seat)) {
            foreach ($seat as $key => $item) {
                if ($item['seat'] == $request->seat) {
                    unset($seat[$key]);
                }
            }
            session(['seat' => $seat]);
            return 'remove';
        } else {
            $seat[$request->seat] = [
                'seat' => $request->seat,
                'id' => $request->id,
                'price' => $request->price,
            ];
            \session(['seat' => $seat]);
            return $seat;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'number' => 'required',
            'gender' => 'required',
            'method' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors(Toastr::error($validator->errors()->all()[0]))->withInput();
        }

        try {
            Order::create([
                'trip_id' => $request->input('trip_id'),
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'number' => $request->input('number'),
                'gender' => $request->input('gender'),
                'method' => $request->input('method'),
                'transaction' => uniqid(),
                'ticked_no' => uniqid(),
                'date' => $request->input('date'),
                'price' => $request->input('price'),
                'seat' => $request->input('seat'),
                'time' => $request->input('time'),
                'status' => 'complete'
            ]);
            Session::forget('seat');
            Toastr::success('Ticked booking successful!!');
            return redirect()->back();
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
