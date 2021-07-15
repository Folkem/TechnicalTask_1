<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('hello', function () {
    return response()->json([
        'status' => 'success',
        'message' => 'hello',
    ]);
});
