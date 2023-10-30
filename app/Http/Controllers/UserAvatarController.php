<?php

namespace App\Http\Controllers;

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
        return Storage::url($path);
    }

    public function get(Request $request)
    {
        if ($request->user()->avatar == null){
            return response()->json(['message' => 'avatar not found']);
        }
        if (Storage::exists($request->user()->avatar)){
            return Storage::url($request->user()->avatar);
        }
        return response()->json(['message' => 'avatar not found']);
    }

    public function delete(Request $request)
    {
        if ($request->user()->avatar != null){
            Storage::delete($request->user()->avatar);
        }
    }
}
