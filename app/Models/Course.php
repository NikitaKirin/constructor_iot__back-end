<?php

namespace App\Models;

use App\Traits\Userable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Orchid\Attachment\Attachable;
use Orchid\Attachment\Models\Attachment;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class Course extends Model
{
    use HasFactory, SoftDeletes, Userable, AsSource, Filterable, Attachable;

    protected $fillable = [
        'title',
        'description',
        'seat_limit',
        'video_id',
        'presentation_id',
        'realization_id',
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
        return $this->belongsTo(Discipline::class)
            ->withDefault(['title' => __('Нет')]);
    }

    /**
     * Relationship - course to realization
     * @return BelongsTo
     */
    public function realization(): BelongsTo {
        return $this->belongsTo(Realization::class);
    }


    /**
     * Relationship - review to attachment (orchid)
     * @return HasOne
     */
    public function video(): HasOne {
        return $this->hasOne(Attachment::class, 'id', 'video_id')->withDefault();
    }

    /**
     * Relationship - review to attachment (orchid)
     * @return HasOne
     */
    public function presentation(): HasOne {
        return $this->hasOne(Attachment::class, 'id', 'presentation_id')->withDefault();
    }

    /**
     * Relationship - review to attachments – documents (orchid)
     * @return MorphToMany
     */
    public function documents(): MorphToMany {
        return $this->attachment('documents');
    }
}
