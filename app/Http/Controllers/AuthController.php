<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
class AuthController extends Controller
{
    // login user
    public function login(){

    }
// create user
    public function register(){
        return view('auth.register');
    }

    public function create(Request $request){

        $validatedData = $request->validate([
            'name'=>'required',
            'email'=>'required|email|unique:users,email',
            'password'=>'required|min:6|confirmed'
        ]);
        $validatedData['password'] = Hash::make($validatedData['password']);
        User::create($validatedData);
        return 'success';
    }
// logout user
    public function logout(){

    }
}
