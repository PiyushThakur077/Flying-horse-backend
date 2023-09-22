<?php

namespace App\Http\Controllers;

use App\Traits\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Auth;

class AdminAuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;
    

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\View\View
     */
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

