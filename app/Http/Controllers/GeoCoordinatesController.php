<?php

namespace App\Http\Controllers;

use App\Models\GeoCoordinate;
use App\Models\Region;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GeoCoordinatesController extends Controller
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
            $result = $result->toArray();

            $adminLevels = $result['adminLevels'];

            $geoCoordinate = GeoCoordinate::query()->firstOrCreate([
                'latitude' => $result['latitude'],
                'longitude' => $result['longitude'],
                'street_number' => $result['streetNumber'],
                'street_name' => $result['streetName'],
                'postal_code' => $result['postalCode'],
                'locality' => $result['locality'],
                'country' => $result['country'],
            ]);

            $regionIds = collect();
            foreach ($adminLevels as $adminLevel) {
                $adminLevelValues = [
                    'name' => $adminLevel['name'],
                    'code' => $adminLevel['code'],
                    'level' => $adminLevel['level'],
                ];
                $region = Region::query()->where('name', $adminLevel['name'])
                    ->where('code', $adminLevel['code'])
                    ->where('level', $adminLevel['level'])
                    ->firstOr(function () use ($adminLevelValues) {
                        return Region::query()->create($adminLevelValues);
                    });
                $regionIds->add($region->id);
            }
            $geoCoordinate->regions()->sync($regionIds);

            return response()->json([
                'status' => 'success',
                'result' => $result,
            ]);
        }

        return response()->json([
            'status' => 'fail',
            'message' => 'Місце за вказаними координатами не було знайдено',
        ]);
    }
}
