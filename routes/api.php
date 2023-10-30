<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdvertController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\UserAvatarController;

Route::middleware('auth:sanctum'/*, 'verified'*/)->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::resource('adverts', AdvertController::class);
    Route::post('/user/avatar', [UserAvatarController::class, 'update']);
    Route::get('/user/avatar', [UserAvatarController::class, 'get']);
    Route::get('/user/avatar', [UserAvatarController::class, 'delete']);
});
