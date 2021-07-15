<?php

namespace App\Models;

use Geocoder\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Class GeoCoordinate
 * @package App\Models
 * @property Collection $regions
 */
class GeoCoordinate extends Model
{
    use HasFactory;

    protected $fillable = [
        'latitude',
        'longitude',
        'street_number',
        'street_name',
        'postal_code',
        'locality',
        'country',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function regions(): BelongsToMany
    {
        return $this->belongsToMany(Region::class);
    }
}
