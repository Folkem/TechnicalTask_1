<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Region
 * @package App\Models
 * @property string $name
 * @property string $code
 * @property int $country_id
 * @property Country $country
 * @property Collection $localities
 */
class Region extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'country_id',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    public function localities(): HasMany
    {
        return $this->hasMany(Locality::class);
    }
}
