<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Services\UserApiService;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }
    public function register()
    {
        return view('auth.register');
    }

    public function verify(Request $request)
    {
        
        $request->validate([
            'name' => 'required',
            'password' => 'required'
        ]);
        if (
            Auth::attempt([
                'name' => $request->name,
                'password' => $request->password
            ])
        ) {
            return redirect()->route('newsp.index');
        } else {
            return redirect()->route('login.index');
        }
    }
    public function store(Request $request)
    {
        if (
            $request->validate([
                'name' => 'required|unique:users',
                'email' => 'required|email|unique:users',
                'password' => 'required|confirmed'
            ])
        ) {
            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]);
            return redirect()->route('login.index');
        } else {
            return redirect()->route('register.index');
        }
    }
    public function logout(){
        Auth::logout();
        session(['username' => null]);
        return redirect()->route('login.index');
    }
}
