<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\Dashboard\{
    PatientController
};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::group(['prefix' => 'v1', 'as' => 'api.'], function(){
    Route::group(['prefix' => 'auth', 'as' => 'auth.'], function(){
        Route::post('register', [AuthController::class, 'register'])->name('register');
        Route::post('login', [AuthController::class, 'login'])->name('login');
    });
});

Route::group(['prefix' => 'v1/dashboard', 'as' => 'api.dashboard.'], function(){
    Route::apiResource('patients', PatientController::class);
});