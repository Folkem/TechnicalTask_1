<?php

use App\Http\Controllers\GeoCoordinatesController;
use Illuminate\Support\Facades\Route;

Route::post('coordinates', [GeoCoordinatesController::class, 'addressByCoordinates']);
