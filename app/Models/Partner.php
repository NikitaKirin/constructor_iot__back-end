<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Orchid\Attachment\Attachable;
use Orchid\Attachment\Models\Attachment;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class Partner extends Model
{
    use HasFactory, AsSource, Attachable, Filterable;

    protected $fillable = [
        'title',
        'site_link',
    ];

    protected $allowedSorts = [
        'title',
        'created_at',
        'updated_at',
    ];

    protected $allowedFilters = [
        'title',
    ];

    /**
     * Relation - partner to user
     * @return BelongsTo
     */
    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }

    /**
     * Relationship - partner to courses
     * @return HasMany
     */
    public function courses(): HasMany {
        return $this->hasMany(Course::class);
    }


    /**
     * Relationship - partner to attachment (orchid)
     * @return HasOne
     */
    public function logo(): HasOne {
        return $this->hasOne(Attachment::class, 'id', 'logo_id')
                    ->withDefault();
    }
}
