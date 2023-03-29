<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function index()
    {
        return view('login');
    }

    public function authenticate(Request $request)
    {
        $request->validate([
            'email-username'    => 'required',
            'password'          => 'required',
        ]);

        $email      = Auth::attempt(['email' => request('email-username'), 'password' => request('password')]);
        $username   = Auth::attempt(['username' => request('email-username'),'password' => request('password')]);

        if ($email || $username) {
            $request->session()->regenerate();
            return redirect()->intended('/dashboard');
        }

        return back()->with('error', 'Login gagal!');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
