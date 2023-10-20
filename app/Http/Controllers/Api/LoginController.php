<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'email|required',
            'password' => 'required|string',
        ]);

        if (!Auth::attempt($request->only(['email', 'password']))) {
            return response()->json(["message" => "The provided credentials do not match our records"], 401);
        }

        $user = User::where('email', $request->email)->first();
        $token = $user->createToken('authToken')->plainTextToken;

        $cookie = cookie('auth_token', $token, 60 * 24 * 7); // set the cookie for 7 days

        return response()->json(['user' => $user, 'token' => $token])->withCookie($cookie);
    }
}
