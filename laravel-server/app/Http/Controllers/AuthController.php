<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{

    public function login(Request $request)
    {
        $username = $request->input('username');

        // Check if user exists or create a new user
        $user = User::firstOrCreate(['username' => $username]);

        // Store user ID in session
        Session::put('user_id', $user->id);

        return response()->json(['message' => 'Login successful', 'user' => $user], 200);
    }

}
