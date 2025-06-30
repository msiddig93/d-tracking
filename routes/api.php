<?php

use App\Http\Controllers\Api\{
    AuthController,
    GlucoseTestController,
    MedicationController as ApiMedicationController
};
use App\Http\Controllers\Api\Dashboard\{
    GlucoseTestController as DashboardGlucoseTestController,
    MedicationController,
    PatientController
};
use App\Http\Controllers\DoctorController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::group(['prefix' => 'v1', 'as' => 'api.'], function(){
    Route::group(['prefix' => 'auth', 'as' => 'auth.'], function(){
        Route::post('register', [AuthController::class, 'register'])->name('register');
        Route::post('login', [AuthController::class, 'login'])->name('login');
        Route::post('logout', [AuthController::class, 'logout'])->name('logout');
    });

    Route::group(['middleware' => 'auth:sanctum', 'prefix' => 'patients'], function(){
        Route::group(['prefix' => 'glucose-tests', 'as' => 'glucose-test.'], function(){
            Route::post('/', [GlucoseTestController::class, 'store'])->name('glucose-test.store');
            Route::get('/history', [GlucoseTestController::class, 'index'])->name('glucose-test.index');
        });
        Route::get('medications', [ApiMedicationController::class, 'index']);
    });
});

Route::group(['prefix' => 'v1/dashboard', 'as' => 'api.dashboard.'], function(){
    Route::apiResource('doctors', DoctorController::class);
    Route::apiResource('patients', PatientController::class);
    Route::apiResource('medications', MedicationController::class);
    Route::apiResource('glucose-tests', DashboardGlucoseTestController::class)->only(['index', 'store', 'destroy']);
});