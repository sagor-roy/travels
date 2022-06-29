<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Destination;
use App\Models\Routee;
use Brian2694\Toastr\Facades\Toastr;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class RouteController extends Controller
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
        if (is_null($this->user) || !$this->user->can('route.view')) {
            abort(403, 'Sorry !! You are Unauthorized to view any admin !');
        }
        $data = Routee::with('froms', 'too')->get();
        return view('backend.route.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (is_null($this->user) || !$this->user->can('route.create')) {
            abort(403, 'Sorry !! You are Unauthorized to view any admin !');
        }
        $dest = Destination::all();
        return view('backend.route.create', compact('dest'));
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
            'name' => 'required|unique:routees',
            'from' => 'required',
            'to' => 'required',
            'distance' => 'required',
            'duration' => 'required',
            'status' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors(Toastr::error($validator->errors()->all()[0]))->withInput();
        }

        try {
            if ($request->input('from') !== $request->input('to')) {
                Routee::create([
                    'name' => $request->input('name'),
                    'from' => $request->input('from'),
                    'to' => $request->input('to'),
                    'distance' => $request->input('distance'),
                    'duration' => $request->input('duration'),
                    'status' => $request->input('status'),
                    'map' => $request->input('map')
                ]);
                Toastr::success('Data created successful!!');
                return redirect()->back();
            }
            Toastr::error('Don\'t same the route location!!');
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
            Routee::find($id)->update(['status' => $request->input('status')]);
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
        if (is_null($this->user) || !$this->user->can('route.edit')) {
            abort(403, 'Sorry !! You are Unauthorized to view any admin !');
        }
        $data = Routee::findOrFail($id);
        $dest = Destination::all();
        return view('backend.route.edit', compact('data', 'dest'));
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
            'name' => 'required|unique:routees,name,' . $id,
            'from' => 'required',
            'to' => 'required',
            'distance' => 'required',
            'duration' => 'required',
            'status' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors(Toastr::error($validator->errors()->all()[0]))->withInput();
        }

        try {
            if ($request->input('from') !== $request->input('to')) {
                Routee::find($id)->update([
                    'name' => $request->input('name'),
                    'from' => $request->input('from'),
                    'to' => $request->input('to'),
                    'distance' => $request->input('distance'),
                    'duration' => $request->input('duration'),
                    'status' => $request->input('status'),
                    'map' => $request->input('map')
                ]);
                Toastr::success('Data update successful!!');
                return redirect()->route('admin.trip.route.index');
            }
            Toastr::error('Don\'t same the route location!!');
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
    public function destroy($id)
    {
        if (is_null($this->user) || !$this->user->can('route.delete')) {
            abort(403, 'Sorry !! You are Unauthorized to view any admin !');
        }
        Routee::find($id)->delete();
        Toastr::success('Data delete successful!!');
        return redirect()->back();
    }
}
