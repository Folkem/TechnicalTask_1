<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Street
 * @package App\Models
 * @property string $name
 * @property int $number
 * @property string $postal_code
 * @property int $locality_id
 * @property Collection $geoCoordinates
 * @property Locality $locality
 */
class Street extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'number',
        'postal_code',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function geoCoordinates(): HasMany
    {
        return $this->hasMany(GeoCoordinate::class);
    }

    public function locality(): BelongsTo
    {
        return $this->belongsTo(Locality::class);
    }
}
