<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GeoController extends Controller
{
    public function addressByCoordinates(Request $request): JsonResponse
    {
        $request->validate([
            'latitude' => [
                'required',
                'numeric',
                'between:-90,90',
            ],
            'longitude' => [
                'required',
                'numeric',
                'between:-180,180',
            ],
        ]);

        return response()->json([
            'status' => 'fail',
            'message' => 'Адреса поки що не повертається',
        ]);
    }
}
