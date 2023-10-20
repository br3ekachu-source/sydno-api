<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\api\LoginController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->group(function () {
    // your authenticated API routes here
})->middleware('web'); // add the web middleware to enable cookies

Route::post('/auth/loginc', [LoginController::class, 'login']);

Route::post('/auth/register', [AuthController::class, 'createUser']);
Route::post('/auth/login', [AuthController::class, 'loginUser']);


//пример защиты аутентификации
//Route::apiResource('posts', PostController::class)->middleware('auth:sanctum');