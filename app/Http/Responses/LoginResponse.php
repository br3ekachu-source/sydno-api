<?php
namespace App\Http\Responses;

use Illuminate\Support\Facades\Auth;
use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;

class LoginResponse implements LoginResponseContract
{

    /**
     * @param  $request
     * @return mixed
     */
    public function toResponse($request)
    {
        // replace this with your own code
        // the user can be located with Auth facade
        
        //$home = Auth::user()->is_admin ? config('fortify.dashboard') : config('fortify.home');
            
        // return $request->wantsJson()
        //     ? response()->json(['two_factor' => false])
        //     : redirect($home);
        return response()->json(['message' => 'Login ok']);
    }

}