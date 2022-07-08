<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Trip;
use Brian2694\Toastr\Facades\Toastr;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Order::latest()->with('trip.routes', 'trip.schedules')->get();
        return view('backend.booking.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $trip = Trip::with('schedules', 'routes', 'types')->get();
        return view('backend.booking.create', compact('trip'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return $request;
        $validator = Validator::make(
            [
                'date' => 'required|date',
                'trip_id' => 'required',
                'name' => 'required',
                'number' => 'required',
                'gender' => 'required',
                'method' => 'required',
                'price' => 'required',
                'number' => 'required',
            ],
            [
                'seat.required' => 'Please select your seat'
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()->withErrors(Toastr::error($validator->errors()->all()[0]))->withInput();
        }

        try {
            if (!is_null($request->input('seat'))) {
                Order::create([
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
                    'seat' => implode("  ", $request->input('seat')),
                    'time' => $request->input('time'),
                    'status' => 'complete'
                ]);
                Session::forget('seats');
                Toastr::success('Ticked booking successful!!');
                return redirect()->route('admin.ticket.booking.index');
            }
            Toastr::error('Please select your seat');
            return redirect()->back();
        } catch (Exception $error) {
            Toastr::error($error->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function trip(Request $request, $id)
    {
        Session::forget('seats');
        $date = $request->input('date');
        $trip = Trip::where('id', $id)->with('vehicles', 'schedules', 'routes', 'types')->first();
        $order = Order::where('trip_id', $trip->id)
            ->where('date', $date)
            ->get()
            ?? [];
        return view('backend.load.seats', compact('trip', 'date', 'order'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $query = $request->input('query');
        $data = Order::where('number', 'LIKE', "%{$query}%")->limit(10)->get();
        return view('backend.load.list', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
