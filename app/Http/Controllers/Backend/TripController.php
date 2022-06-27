<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Fleet;
use App\Models\Routee;
use App\Models\Schedule;
use App\Models\Trip;
use Brian2694\Toastr\Facades\Toastr;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TripController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Trip::with('types', 'routes', 'schedules')->get();
        return view('backend.trip.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $type = Fleet::all();
        $route = Routee::all();
        $schedule = Schedule::all();
        return view('backend.trip.create', compact('type', 'route', 'schedule'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'type' => 'required',
            'route' => 'required',
            'schedule' => 'required',
            'status' => 'required',
            'price' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors(Toastr::error($validator->errors()->all()[0]))->withInput();
        }

        try {
            Trip::create([
                'title' => $request->input('title'),
                'type_id' => $request->input('type'),
                'route_id' => $request->input('route'),
                'schedule_id' => $request->input('schedule'),
                'status' => $request->input('status'),
                'price' => $request->input('price'),
            ]);
            Toastr::success('Data created successful!!');
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
    public function status(Request $request, $id)
    {
        try {
            Trip::find($id)->update(['status' => $request->input('status')]);
            return response()->json(200);
        } catch (Exception $error) {
            Toastr::error($error->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $type = Fleet::all();
        $route = Routee::all();
        $schedule = Schedule::all();
        $data = Trip::findorfail($id);
        return view('backend.trip.edit', compact('type', 'route', 'schedule', 'data'));
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
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'type' => 'required',
            'route' => 'required',
            'schedule' => 'required',
            'price' => 'required',
            'status' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors(Toastr::error($validator->errors()->all()[0]))->withInput();
        }

        try {
            Trip::findorfail($id)->update([
                'title' => $request->input('title'),
                'type_id' => $request->input('type'),
                'route_id' => $request->input('route'),
                'schedule_id' => $request->input('schedule'),
                'price' => $request->input('price'),
                'status' => $request->input('status'),
            ]);
            Toastr::success('Data update successful!!');
            return redirect()->route('admin.trip.index');
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
    public function destroy($id)
    {
        Trip::findOrFail($id)->delete();
        Toastr::success('Data delete successful!!');
        return redirect()->back();
    }
}
