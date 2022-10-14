<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Orchid\Attachment\Attachable;
use Orchid\Attachment\Models\Attachment;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class Review extends Model
{
    use HasFactory, AsSource, Filterable, Attachable;

    protected $fillable = [
        'author',
        'text',
        'educational_direction',
        'year_of_issue',
        'course',
        'hidden',
        'photo_id',
    ];

    /**
     * Relationship - review to user
     * @return BelongsTo
     */
    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }

    /**
     * Relationship - review to attachment (orchid)
     * @return HasOne
     */
    public function photo(): HasOne {
        return $this->hasOne(Attachment::class, 'id', 'photo_id')
                    ->withDefault();
    }
}
