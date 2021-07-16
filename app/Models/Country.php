<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Country
 * @package App\Models
 * @property string $name
 * @property string $code
 * @property Collection $regions
 */
class Country extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function regions(): HasMany
    {
        return $this->hasMany(Region::class);
    }
}
