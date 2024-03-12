<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function loginPage(){
        return view('backend.pages.auth.login');
    }

    public function login(Request $request){
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:4'
        ]);

        $credentials = [
            'email' => $request->email,
            'password' => $request->password
        ];

        // Login attempt if success then redirect ot dashboard
        if(Auth::attempt($credentials, $request->filled('remember'))){
            $request->session()->regenerate();
            return redirect()->intended('admin/dashboard');
        }

        // return error message
        return back()->withErrors([
            'email' => 'Wrong Credentials Found'
        ])->onlyInput('email');
    }

    public function logOut(Request $request){
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }
}
