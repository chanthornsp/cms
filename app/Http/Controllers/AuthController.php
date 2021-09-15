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
        // // get info user logged in with Normal User
        // Auth::user();
        // // get info user logged in with guard admin
        // Auth::guard('admin')->user();

        if(Auth::guard('admin')->check()){
            return redirect()->route('admin.index');
        }elseif(Auth::check()){
            return redirect()->route('dashboard');
        }else{
            return view('auth.login');
        }
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

        $remember = false;
        if ($request->remember) {
            $remember = true;
        }
        $user = User::where('email', $request->email)
                // ->where('active',1)
                ->first();
// dd($user->role);
        if($user && $user->role === 'admin' && Hash::check($request->password, $user->password)){
                Auth::guard('admin')->login($user,$remember);
                return redirect()->route('admin.index');
        }

        if ($user && Hash::check($request->password, $user->password)) {
            Auth::login($user,$remember);
            return redirect()->route('dashboard');
        }


        // if (Auth::attempt(['email' => $request->email, 'password' => $request->password],$remember)) {
        //     $request->session()->regenerate();

        //     return redirect()->route('dashboard');
        // }

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
