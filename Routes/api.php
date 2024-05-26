<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Auth\Http\Controllers\AuthController;
use Modules\Auth\Http\Controllers\ProfileController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/auth', function (Request $request) {
//     return $request->user();
// });


Route::group([
    'prefix' => 'auth',
], function () {
    Route::post('register'             , [AuthController::class, 'register']);
    Route::post('login'                , [AuthController::class, 'login']);
    Route::post('logout'               , [AuthController::class, 'logout'])->middleware('auth:sanctum'); 

    Route::post('forgot-password'      , [AuthController::class, 'forgotPassword']);
    Route::post('check-otp'            , [AuthController::class, 'checkOTP']);
    Route::post('reset-password'       , [AuthController::class, 'resetPassword']);
    Route::post('change-password'      , [AuthController::class, 'changePassword'])->middleware("auth:user"); 

});


Route::group([
    'prefix' => 'profile',
], function () {
    Route::get('/'                             , [ProfileController::class, 'index']);
    Route::get('-edit'                         , [ProfileController::class, 'show']);
    Route::get('-update'                       , [ProfileController::class, 'update']);
});
