<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdvertController;
use App\Http\Controllers\AdvertLegalInformationController;
use App\Http\Controllers\AdvertTechnicalInformationController;
use App\Http\Controllers\UserAvatarController;
use App\Http\Controllers\UserController;
use App\Models\AdvertLegalInformation;
use App\Models\AdvertTechnicalInformation;
use App\Http\Services\Consts;

Route::middleware('auth:sanctum'/*, 'verified'*/)->group(function () {
    Route::get('/user', [UserController::class, 'get']);
    Route::resource('adverts', AdvertController::class);
    Route::resource('adverts_legal_information', AdvertLegalInformationController::class);
    Route::resource('adverts_technical_information', AdvertTechnicalInformationController::class);
    Route::post('/user/avatar', [UserAvatarController::class, 'update']);
    Route::get('/user/avatar', [UserAvatarController::class, 'get']);
    Route::get('/user/avatar', [UserAvatarController::class, 'delete']);
});

Route::get('selector/vessel_types', function() {
    return Consts::getVesselTypes();
});
