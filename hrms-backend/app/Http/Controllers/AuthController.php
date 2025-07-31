<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request){
       $validated = $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
        $user=User::create([
            'name'=>$validated['name'],
            'email'=>$validated['email'],
            'password'=>Hash::make($validated['password']),
        ]);
        Auth::login($user);
        $request->session->regenerate();
        return response()->json(['message' => 'User registered sucessfully']);
    }
    public function login(Request $request){
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
        if(!Auth::attempt($credentials)){
            return response()->json(['message'=>'Invalid Credentials'],401);
        }
        $request->session()->regenerate();
        return response()->json(['message'=>'User logged in successfully'],201);

    }
    public function logout(Request $request){
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerate();
        return response()->json(['message'=>'User logout successfully']);
    }
    public function user(Request $request){
        return $request->user();
    }
}
