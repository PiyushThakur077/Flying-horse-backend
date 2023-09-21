<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class AdminAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            return view('admin.dashboard');
        } else {
            return redirect()->route('admin.login')->with('error', 'Invalid credentials');
        }
    }
    public function logout(Request $request)
    {
        Auth::logout();
        return redirect()->route('admin.login')->with('success', 'You have been logged out.');
    }
}
