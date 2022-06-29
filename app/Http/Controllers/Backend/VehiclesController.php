<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Fleet;
use App\Models\Vehicles;
use Brian2694\Toastr\Facades\Toastr;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class VehiclesController extends Controller
{
    public $user;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            return $next($request);
        });
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (is_null($this->user) || !$this->user->can('vehicle.view')) {
            abort(403, 'Sorry !! You are Unauthorized to view any admin !');
        }
        $data = Vehicles::with('types')->latest()->get();
        return view('backend.vehicles.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (is_null($this->user) || !$this->user->can('vehicle.create')) {
            abort(403, 'Sorry !! You are Unauthorized to view any admin !');
        }
        $fleet = Fleet::where('status', 1)->get();
        return view('backend.vehicles.create', compact('fleet'));
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
            'regis' => 'required|unique:vehicles',
            'type' => 'required',
            'engine_no' => 'required|unique:vehicles',
            'model_no' => 'required|unique:vehicles',
            'chasis_no' => 'required|unique:vehicles',
            'owner' => 'required',
            'owner_phone' => 'required',
            'brand' => 'required',
            'status' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors(Toastr::error($validator->errors()->all()[0]))->withInput();
        }

        try {
            Vehicles::create([
                'regis' => $request->input('regis'),
                'type_id' => $request->input('type'),
                'engine_no' => $request->input('engine_no'),
                'model_no' => $request->input('model_no'),
                'chasis_no' => $request->input('chasis_no'),
                'owner' => $request->input('owner'),
                'owner_phone' => $request->input('owner_phone'),
                'brand' => $request->input('brand'),
                'status' => $request->input('status')
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
            Vehicles::find($id)->update(['status' => $request->input('status')]);
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
        if (is_null($this->user) || !$this->user->can('vehicle.edit')) {
            abort(403, 'Sorry !! You are Unauthorized to view any admin !');
        }
        $data = Vehicles::findOrFail($id);
        $fleet = Fleet::where('status', 1)->get();
        return view('backend.vehicles.edit', compact('data', 'fleet'));
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
            'regis' => 'required|unique:vehicles,regis,'.$id,
            'type' => 'required',
            'engine_no' => 'required|unique:vehicles,engine_no,'.$id,
            'model_no' => 'required|unique:vehicles,model_no,'.$id,
            'chasis_no' => 'required|unique:vehicles,chasis_no,'.$id,
            'owner' => 'required',
            'owner_phone' => 'required',
            'brand' => 'required',
            'status' => 'required',
        ], [
            'regis.required' => 'The registration field is require'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors(Toastr::error($validator->errors()->all()[0]))->withInput();
        }

        try {
            Vehicles::findOrFail($id)->update([
                'regis' => $request->input('regis'),
                'type_id' => $request->input('type'),
                'engine_no' => $request->input('engine_no'),
                'model_no' => $request->input('model_no'),
                'chasis_no' => $request->input('chasis_no'),
                'owner' => $request->input('owner'),
                'owner_phone' => $request->input('owner_phone'),
                'brand' => $request->input('brand'),
                'status' => $request->input('status')
            ]);
            Toastr::success('Data update successful!!');
            return redirect()->route('admin.fleet.vehicles.index');
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
        if (is_null($this->user) || !$this->user->can('vehicle.delete')) {
            abort(403, 'Sorry !! You are Unauthorized to view any admin !');
        }
        Vehicles::findOrFail($id)->delete();
        Toastr::success('Data delete successful!!');
        return redirect()->back();
    }
}
