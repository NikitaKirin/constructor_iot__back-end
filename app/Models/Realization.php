<?php

namespace App\Models;

use App\Traits\Userable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Realization extends Model
{
    use HasFactory, SoftDeletes, Userable;

    protected $fillable = [
        'title',
    ];

    /**
     * Relationship - realization to courses
     * @return HasMany
     */
    public function courses(): HasMany {
        return $this->hasMany(Course::class);
    }
}
