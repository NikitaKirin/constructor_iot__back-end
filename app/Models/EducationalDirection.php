<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class EducationalDirection extends Model
{
    use HasFactory, SoftDeletes, AsSource, Filterable;

    protected $table = "educational_directions";

    protected $fillable = [
        'title',
        'cipher',
        'passing_scores',
        'training_period',
        'budget_places',
    ];

    protected $casts = [
        'passing_scores' => 'array',
    ];

    /**
     * Relationship - educational direction to user
     * @return BelongsTo
     */
    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }

    /**
     * Relationship - educational direction to educational modules
     * @return BelongsToMany
     */
    public function educationalModules(): BelongsToMany {
        return $this->belongsToMany(EducationalModule::class);
    }

    /**
     * Relationship - educational direction to institute
     * @return BelongsTo
     */
    public function institute(): BelongsTo {
        return $this->belongsTo(Institute::class);
    }
}
