<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\GeoCoordinate;
use App\Models\Region;
use Exception;
use Illuminate\Database\Eloquent\Builder;
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
                $validated['longitude']
            )
            ->get()
            ->first();

        if (isset($result)) {
            $result = $result->toArray();

            try {
                $this->storeGeoCoordinateInformation($result);
            } catch (Exception $e) {
                logger()->warning(
                    "{$e->getMessage()} at {$e->getFile()}:{$e->getLine()}"
                );
            }

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

    /**
     * @param array $info location information, gotten from Geocoding API
     * @throws Exception if location info contains data, which doesn't fit into the
     * database constraints
     */
    private function storeGeoCoordinateInformation(array $info)
    {
        $adminLevels = $info['adminLevels'];
        $regionAdminLevel = $adminLevels['1'];

        $country = Country::query()->firstOrCreate([
            'name' => $info['country'],
            'code' => $info['countryCode'],
        ]);

        $region = $country->regions()->firstOrCreate([
            'name' => $regionAdminLevel['name'],
            'code' => $regionAdminLevel['code'],
        ]);

        $city = $info['locality'] ?: $info['subLocality'];

        $locality = $region->localities()->firstOrCreate([
            'name' => $city,
        ]);

        $street = $locality->streets()->firstOrCreate([
            'name' => $info['streetName'],
            'number' => $info['streetNumber'],
            'postal_code' => $info['postalCode'],
        ]);

        $street->geoCoordinates()->firstOrCreate([
            'latitude' => $info['latitude'],
            'longitude' => $info['longitude'],
        ]);
    }

    public function addresses(Region $region): JsonResponse
    {
        if (empty($region->id)) {
            return response()->json([
                'status' => 'success',
                'results' => GeoCoordinate::all(),
            ]);
        }

        return response()->json([
            'status' => 'success',
            'results' => GeoCoordinate::query()
                ->whereHas('street.locality.region', function (Builder $query) use ($region) {
                    return $query->where('id', $region->id);
                })
                ->get(),
        ]);
    }
}
