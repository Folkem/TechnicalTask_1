<?php

namespace App\Http\Controllers;

use Geocoder\Laravel\Facades\Geocoder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GeoController extends Controller
{
    public function addressByCoordinates(Request $request): JsonResponse
    {
        $validated = $request->validate([
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

        $result = app('geocoder')
            ->reverse(
                $validated['latitude'],
                $validated['longitude'],
            )
            ->get()
            ->first();

        if (isset($result)) {
            return response()->json([
                'status' => 'success',
                'result' => $result->toArray(),
            ]);
        }

        return response()->json([
            'status' => 'fail',
            'message' => 'Місце за вказаними координатами не було знайдено',
        ]);
    }
}
