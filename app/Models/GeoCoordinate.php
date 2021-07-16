<?php

namespace App\Models;

use Geocoder\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Class GeoCoordinate
 * @package App\Models
 * @property double $latitude
 * @property double $longitude
 * @property int $street_id
 * @property Street $street
 */
class GeoCoordinate extends Model
{
    use HasFactory;

    protected $fillable = [
        'latitude',
        'longitude',
        'street_id',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function street(): BelongsTo
    {
        return $this->belongsTo(Street::class);
    }
}
