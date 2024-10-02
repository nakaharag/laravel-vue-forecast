<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WeatherController;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/locations', [WeatherController::class, 'addLocation']);
    Route::delete('/locations/{id}', [WeatherController::class, 'removeLocation']);
    Route::get('/locations', [WeatherController::class, 'getLocations']);
});
