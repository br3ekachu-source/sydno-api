<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdvertController;
use App\Http\Controllers\AdvertLegalInformationController;
use App\Http\Controllers\AdvertTechnicalInformationController;
use App\Http\Controllers\ConstController;
use App\Http\Controllers\UserAvatarController;
use App\Http\Controllers\UserController;
use App\Http\Services\Consts;
use App\Models\Advert;
use Illuminate\Support\Facades\Storage;

Route::middleware('auth:sanctum'/*, 'verified'*/)->group(function () {
    Route::get('/user', [UserController::class, 'get']);
    Route::resource('adverts', AdvertController::class);
    Route::get('advertsinfo', [AdvertController::class, 'getInfo']);

    Route::get('myadverts/{state}', [AdvertController::class, 'getMyAdverts']);

    Route::resource('advertslegalinformation', AdvertLegalInformationController::class);
    Route::resource('advertstechnicalinformation', AdvertTechnicalInformationController::class);
    Route::post('/user/avatar', [UserAvatarController::class, 'update']);
    Route::get('/user/avatar', [UserAvatarController::class, 'get']);
    Route::delete('/user/avatar', [UserAvatarController::class, 'delete']);
});

Route::get('selector', [ConstController::class, 'getSelectors']);

Route::get('selector/vesseltypes', function() {
    return response()->json(['message' => [
        'vessel_types' => Consts::getVesselTypes()
    ]]);
});

Route::get('/files/{folder}/{filename}', function($folder, $filename){
    $path = $folder.'/'.$filename;
    if (Storage::exists($path)){
        return Storage::get($path);
    }
    return response()->json(['message' => 'Файл '.$filename.' не найден'], 404);
});
//http://localhost/storage/avatars/