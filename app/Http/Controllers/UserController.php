<?php

namespace App\Http\Controllers;

use App\Http\Services\Files;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function get(Request $request)
    {
        $user = $request->user();
        $response = [];
        $response['id'] = $user->id;
        $response['name'] = $user->name;
        $response['phone_number'] = $user->phone_number;
        $response['email'] = $user->email;
        $response['email_verified_at'] = $user->email_verified_at;
        $response['avatar'] = isset($user->avatar) && Storage::exists($user->avatar) ? Files::getUrl($user->avatar) : null;
        $response['created_at'] = $user->created_at;

        return response()->json($response);
    }

    public function show($id)
    {
        $user = User::find($id);
        $response = [];
        $response['id'] = $user->id;
        $response['name'] = $user->name;
        $response['phone_number'] = $user->phone_number;
        $response['email'] = $user->email;
        //$response['email_verified_at'] = $user->email_verified_at;
        $response['avatar'] = isset($user->avatar) && Storage::exists($user->avatar) ? Files::getUrl($user->avatar) : null;
        //$response['created_at'] = $user->created_at;

        return response()->json($response);
    }
}
