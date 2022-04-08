<?php

use App\Http\Controllers\AccessController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/log-out', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::get('/user-profile', [AuthController::class, 'userProfile']);

    Route::get('/cars-list',[AccessController::class,'get_cars']);
    Route::get('/cus-list',[AccessController::class,'get_customers']);
    Route::get('/get-report',[AccessController::class,'admin_report']);
    Route::get('/cars-data/{id}',[AccessController::class,'get_trips']);
    Route::get('/reports/{id}',[AccessController::class,'reports']);
    Route::post('/search',[AccessController::class,'search']);
    Route::post('/get_search',[PaymentController::class,'get_search']);
    Route::post('/car_search/{id}',[AccessController::class,'car_search']);
    

    Route::post('/add-day-trip',[PaymentController::class,'add_day_trip']);
    Route::post('/local-trip',[PaymentController::class,'add_local_trip']);
    Route::post('/hills-trip',[PaymentController::class,'add_hills_trip']);
    Route::post('/taxi-trip',[PaymentController::class,'add_taxi_trip']);
    Route::post('/drivers_logins',[PaymentController::class,'drivers_logins']);
    Route::get('/hanshake/{car_id}',[PaymentController::class,'hanshake']);
    Route::put('/logout/{car_id}',[PaymentController::class,'logout']);
    Route::post('/Caronedaytrip',[PaymentController::class,'Caronedaytrip']);
    Route::get('/get_seaters',[PaymentController::class,'get_seaters']);
});
    
