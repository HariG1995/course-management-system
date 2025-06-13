<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function userLogin(){
        return view('auth/login');
    }

    public function checkLogin(Request $request){
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required'
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            return response()->json([
                'status' => true,
                'message' => 'Login successful',
                'redirect' => route('home')
            ]);
        }

        return response()->json([
            'status' => false,
            'message' => 'Invalid credentials'
        ]);
    }

    public function userLogout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
