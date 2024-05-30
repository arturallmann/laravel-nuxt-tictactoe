<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request) {
        $validatedData = $request->validate([
            'username'=>'required|unique:users',
            'password'=>'required|min:8'
        ]);
        $user = User::create([
            'username'=>$validatedData['username'],
            'password'=>Hash::make($validatedData['password']),
        ]);
        return response()->json(['message'=>'User added successfully'], 201);
    }
    public function login(Request $request) {
        $validatedData = $request->validate([
            'username'=>'required',
            'password'=>'required'
        ]);

        if(!Auth::attempt($validatedData)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }
        $user = Auth::user();
        $token = $user->createToken('authToken')->plainTextToken;

        return response()->json(['token' =>$token, 'user'=>$user]);
    }
    public function logout(Request $request) {
        $request->user()->tokens()->delete();
        return response()->json(['message' => 'Logged out successfully']);
    }
    public function user(Request $request)
    {
        return response()->json($request->user());
    }
}
