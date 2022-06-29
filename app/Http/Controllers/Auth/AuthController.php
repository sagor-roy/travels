<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function access(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors(Toastr::error($validator->errors()->all()[0]))->withInput();
        }

        $creadential = $request->only(['email', 'password']);

        if (Auth::attempt($creadential)) {
            Toastr::success('Welcome to Dashboard');
            return redirect()->route('admin.dashboard');
        }
        Toastr::error('Creadential does\'t match our record');
        return redirect()->back();
    }

    public function logout()
    {
        Auth::logout();
        Toastr::success('Logout Successful!!!!');
        return redirect()->route('home');
    }
}
