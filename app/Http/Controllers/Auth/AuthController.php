<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

use function Ramsey\Uuid\v1;

class AuthController extends Controller
{
    public function login()
    {

        if (Auth::check()) {
            // If user is authenticated, redirect to admin home with no-cache header
            return redirect()->route('dashboard');
        } else {
            // If user is not authenticated, return login view
            return view('admin.authenication.login');
        }
    }
    public function dashboard()
    {
        return view('admin.dashboard.dashborad');
    }
    public function loginPost(Request $request)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Attempt to authenticate the user
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            // Authentication passed, display success toastr and redirect to dashboard
            Toastr::success('You have successfully logged in!', 'Success');
            return response()->json(['redirect' => route('dashboard')], 200);
        }

        // Authentication failed
        Toastr::error('Invalid credentials, please try again.', 'Error');
        return response()->json(['errors' => ['login' => 'Invalid credentials']], 401);
    }

    public function logout(Request $request)
    {
        Auth::logout();
 
        $request->session()->invalidate();
     
        $request->session()->regenerateToken();
        // For API routes, return a JSON response
        if ($request->expectsJson()) {
            return response()->json(['message' => 'Logged out successfully']);
        }
        // For web routes, redirect back to login or any other route
        Toastr::success('You have successfully Log out!', 'Success');
        return redirect()->route('login');
    }

    public function createUser()
    {
        return view('admin.user.create-user');
    }
}
