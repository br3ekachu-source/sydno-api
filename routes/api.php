<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdvertController;

Route::middleware('auth:sanctum'/*, 'verified'*/)->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::resource('adverts', AdvertController::class);
});

