<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\Api\Auth\LoginAuthRequest;
use App\Http\Requests\Api\Auth\RegisterAuthRequest;

class AuthController extends Controller
{
    public function login(LoginAuthRequest $request)
    {
        if (!Auth::attempt($request->only(['email', 'password']))) {
            return response()->json(["message" => "Неверный адрес почты или пароль"], 401);
        }

        $user = User::where('email', $request->email)->first();
        $token = $user->createToken('authToken')->plainTextToken;

        $cookie = cookie('auth_token', $token, 60 * 24 * 7); // set the cookie for 7 days

        return response()->json(['user' => $user, 'token' => $token])->withCookie($cookie);
    }

    public function register(RegisterAuthRequest $request)
    {
        if (User::where('email', $request->email)->exists()) {
            return response()->json(["message" => "Пользователь с таким email уже существует"], 401);
        }
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);
        
        $user = User::where('email', $request->email)->first();
        $token = $user->createToken('authToken')->plainTextToken;

        $cookie = cookie('auth_token', $token, 60 * 24 * 7); // set the cookie for 7 days

        return response()->json(['user' => $user, 'token' => $token])->withCookie($cookie);
    }
    
}
