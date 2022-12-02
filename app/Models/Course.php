<?php

namespace App\Models;

use App\Traits\Userable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class Course extends Model
{
    use HasFactory, SoftDeletes, Userable, AsSource, Filterable;

    protected $fillable = [
        'title',
        'description',
        'limit',
    ];

    protected $allowedSorts = [
        'title',
        'limit',
        'created_at',
        'updated_at',
    ];

    protected $allowedFilters = [
        'title',
        'limit',
    ];

    /**
     * Relationship - course to user
     * @return BelongsTo
     */
    public function partner(): BelongsTo {
        return $this->belongsTo(Partner::class)->withDefault(['title' => __('Нет')]);
    }

    /**
     * Relationship - course to discipline
     * @return BelongsTo
     */
    public function discipline(): BelongsTo {
        return $this->belongsTo(Discipline::class);
    }

    /**
     * Relationship - course to realization
     * @return BelongsTo
     */
    public function realization(): BelongsTo {
        return $this->belongsTo(Realization::class);
    }
}
