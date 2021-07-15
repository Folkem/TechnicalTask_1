<?php

namespace App\Models;

use Geocoder\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Class Region
 * @package App\Models
 * @property Collection $geoCoordinates
 */
class Region extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'level',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function geoCoordinates(): BelongsToMany
    {
        return $this->belongsToMany(GeoCoordinate::class);
    }
}
