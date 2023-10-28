<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdvertController;
use App\Http\Controllers\Auth\VerifyEmailController;

Route::middleware('auth:sanctum', 'verified')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::resource('adverts', AdvertController::class);
    
});
