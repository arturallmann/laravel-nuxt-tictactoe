<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(Request $request) {
        $validatedData = $request->validate([
            'username'=>'required',
        ]);
        $user = User::create([
            'username'=>$validatedData['username'],
        ]);
        return response()->json(['message'=>'User added successfully'], 201);
    }
    public function login(Request $request) {
        $validatedData = $request->validate([
            'username'=>'required',
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
