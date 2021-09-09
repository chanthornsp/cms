<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // show login form
    public function login()
    {
        return view('auth.login');
    }
    // show register form
    public function register()
    {
        return view('auth.register');
    }
    // create user and inster to database
    public function create(Request $request)
    {

        $validatedData = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed'
        ]);
        $validatedData['password'] = Hash::make($validatedData['password']);
        $user = User::create($validatedData);
        Auth::login($user);
        return redirect()->route('dashboard');
    }

    public function loginUser(Request $request)
    {

        $validatedData = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // $user = User::where('email', $request->email)
        //         // ->where('active',1)
        //         ->first();
        // if ($user && Hash::check($request->password, $user->password)) {
        //     Auth::login($user);
        //     return redirect()->route('dashboard');
        // }
        $remember = false;
        if ($request->remember) {
            $remember = true;
        }

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password],$remember)) {
            $request->session()->regenerate();

            return redirect()->route('dashboard');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    // logout user
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
