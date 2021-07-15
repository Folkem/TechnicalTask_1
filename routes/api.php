<?php

use App\Http\Controllers\GeoCoordinatesController;
use Illuminate\Support\Facades\Route;

Route::post('coordinates', [GeoCoordinatesController::class, 'addressByCoordinates']);
Route::get('addresses/{region?}', [GeoCoordinatesController::class, 'addresses']);
