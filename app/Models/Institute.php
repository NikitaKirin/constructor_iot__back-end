<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class Institute extends Model
{
    use HasFactory, SoftDeletes, AsSource, Filterable;

    protected $fillable = [
        'title',
        'abbreviation',
    ];

    protected array $allowedSorts = [
        'title',
        'abbreviation',
        'updated_at',
    ];

    /**
     * Relationship - institute to user
     * @return BelongsTo
     */
    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }

    /**
     * Relationship - institute to educational directions
     * @return HasMany
     */
    public function educationalDirections(): HasMany {
        return $this->hasMany(EducationalDirection::class);
    }
}
