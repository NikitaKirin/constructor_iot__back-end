<?php

namespace App\Models;

use App\Traits\Userable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
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
        'partner_id',
        'course_assembly_id',
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
        return $this->belongsTo(Partner::class);
    }

    /**
     * Relationship - course to discipline
     * @return BelongsToMany
     */
    public function courseAssemblies(): BelongsToMany {
        return $this->belongsToMany(CourseAssembly::class, 'course_assembly_course');
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
