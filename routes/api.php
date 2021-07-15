<?php

use App\Http\Controllers\GeoController;
use Illuminate\Support\Facades\Route;

Route::post('coordinates', [GeoController::class, 'addressByCoordinates']);
