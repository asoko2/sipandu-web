<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

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
            if (Auth::user()->role_id == 1) {
                return redirect()->intended('admin/dashboard');
            } else if (Auth::user()->role_id == 2) {
                return redirect()->intended('verifikator/dashboard');
            } else {
                return redirect()->intended('operator/dashboard');
            }
        }

        return back()->withErrors([
            'username' => 'The provided credentials do not match our records.',
        ])->onlyInput('username');
    }

    public function changePassword()
    {
        return view('change-password', ['nav' => '']);
    }

    public function updatePassword(Request $request)
    {

        $request->validate([
            'old_password' => 'required',
            'password' => 'required|confirmed'
        ], [
            'password.confirmed' => 'Password baru tidak sama',
        ]);

        $user = User::find(Auth::user()->id);

        if (!Hash::check($request->old_password, $user->password)) {
            // dd('password sallah');
            Session::flash('message', 'Password Lama Salah');
            Session::flash('alert-class', 'alert-danger');
            
            return redirect('change-password');
        }
        
        // dd('password betul');
        $user->password = Hash::make($request->input('password'));

        $user->save();

        Session::flash('message', 'Password Berhasil Diubah');
        Session::flash('alert-class', 'alert-success');

        return redirect('change-password');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
