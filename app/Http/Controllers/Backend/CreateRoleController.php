<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class CreateRoleController extends Controller
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
        if (is_null($this->user) || !$this->user->can('role.view')) {
            abort(403, 'Sorry !! You are Unauthorized to view any admin !');
        }
        $roles = Role::where('id', '!=', 1)->get();
        return view('backend.roles.create.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (is_null($this->user) || !$this->user->can('role.create')) {
            abort(403, 'Sorry !! You are Unauthorized to view any admin !');
        }
        $group = User::getGroupName();
        $allPermissions = Permission::get();
        $total = count($group) + count($allPermissions);
        return view('backend.roles.create.create', compact('group', 'allPermissions', 'total'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'role' => 'required|unique:roles,name',
            ],
            [
                'role.required' => 'The role name field is require'
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()->withErrors(Toastr::error($validator->errors()->all()[0]))->withInput();
        }

        $role = Role::create(['name' => $request->input('role')]);
        $permission = $request->input('permission');
        if (!empty($permission)) {
            $role->syncPermissions($permission);
        }
        Toastr::success('Role create successful!!');
        return redirect()->back();
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
        if (is_null($this->user) || !$this->user->can('user.edit')) {
            abort(403, 'Sorry !! You are Unauthorized to view any admin !');
        }
        if ($id != 1) {
            $group = User::getGroupName();
            $allPermissions = Permission::get();
            $total = count($group) + count($allPermissions);
            $roles = Role::findorfail($id);
            return view('backend.roles.create.edit', compact('group', 'allPermissions', 'total', 'roles'));
        }
        abort(404);
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
        $validator = Validator::make(
            $request->all(),
            [
                'role' => 'required',
            ],
            [
                'role.required' => 'The role name field is require'
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()->withErrors(Toastr::error($validator->errors()->all()[0]))->withInput();
        }

        $role = Role::find($id);
        $permission = $request->input('permission');
        if (!empty($permission)) {
            $role->syncPermissions($permission);
        }
        Toastr::success('Role update successful!!');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (is_null($this->user) || !$this->user->can('user.delete')) {
            abort(403, 'Sorry !! You are Unauthorized to view any admin !');
        }
        $role = Role::find($id);
        if (!is_null($role)) {
            $role->delete();
        }
        Toastr::success('Role delete successful!!');
        return redirect()->back();
    }
}
