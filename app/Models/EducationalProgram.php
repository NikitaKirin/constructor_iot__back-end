<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class EducationalProgram extends Model
{
    use HasFactory, SoftDeletes, AsSource, Filterable;

    protected $table = "educational_programs";

    protected $fillable = [
        'title',
        'educational_direction',
        'passing_scores',
        'training_period',
        'budget_places',
        'page_link',
    ];

    protected $allowedSorts = [
        'title',
        'created_at',
        'updated_at',
    ];

    protected $allowedFilters = [
        'title',
    ];

    protected $casts = [
        'passing_scores' => 'array',
    ];

    /**
     * Relationship - educational direction to user
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relationship - educational direction to educational modules
     * @return HasMany
     */
    public function disciplines(): HasMany
    {
        return $this->hasMany(Discipline::class);
    }

    /**
     * Relationship - educational direction to institute
     * @return BelongsTo
     */
    public function institute(): BelongsTo
    {
        return $this->belongsTo(Institute::class);
    }
}
