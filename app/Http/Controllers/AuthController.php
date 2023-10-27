<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            if(Auth::user()->role_id == 1){
                return redirect()->intended('admin/dashboard');
            }else if(Auth::user()->role_id ==2){
                return redirect()->intended('verifikator/dashboard');                
            }else{
                return redirect()->intended('operator/dashboard');
            }
        }
        
        return back()->withErrors([
            'username' => 'The provided credentials do not match our records.',
        ])->onlyInput('username');
    }
}
