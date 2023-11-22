<?php

namespace App\Http\Controllers;

use App\Http\Services\Files;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserAvatarController extends Controller
{
    public function update(Request $request)
    {
        $this->validate($request, ['avatar_image' => 'required|image|mimes:jpeg,png,jpg,svg:max:2048']);
        if(!$request->hasFile('avatar_image')){
            return response()->json(['message' => 'avatar field is required']);
        }
        $path = $request->file('avatar_image')->store('avatars');
        if (!$path){
            return response()->json(['message' => 'avatar has not been saved']);
        }
        if ($request->user()->avatar != null){
            Storage::delete($request->user()->avatar);
        }
        $request->user()->avatar = $path;
        $request->user()->save();
        return Files::getUrl($path);
    }

    public function get(Request $request)
    {
        if ($request->user()->avatar == null){
            return response()->json(['message' => 'Пользователь не найден']);
        }
        if (Storage::exists($request->user()->avatar)){
            return Files::getUrl($request->user()->avatar);
        }
        return response()->json(['message' => 'У пользователя нет аватара']);
    }

    public function get_avatar(Request $request, $user_id)
    {
        $user = User::find($user_id);
        if ($user == null) {
            return response()->json(['message' => 'Пользователь не найден']);
        }
        if ($user->avatar == null){
            return response()->json(['message' => 'У пользователя нет аватара']);
        }
        if (Storage::exists($user->avatar)){
            return Files::getUrl($user->avatar);
        }
        return response()->json(['message' => 'Аватар не найден']);
    }

    public function delete(Request $request)
    {
        if ($request->user()->avatar != null){
            Storage::delete($request->user()->avatar);
        }
    }
}
