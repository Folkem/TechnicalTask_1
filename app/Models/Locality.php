<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Locality
 * @package App\Models
 * @property string $name
 * @property int $country_id
 * @property Collection $streets
 * @property Region $region
 */
class Locality extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'country_id',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function streets(): HasMany
    {
        return $this->hasMany(Street::class);
    }

    public function region(): BelongsTo
    {
        return $this->belongsTo(Region::class);
    }
}
