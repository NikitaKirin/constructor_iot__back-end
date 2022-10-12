<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Course extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'limit',
    ];

    /**
     * Relationship - course to user
     * @return BelongsTo
     */
    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }

    /**
     * Relationship - course to user
     * @return BelongsTo
     */
    public function partner(): BelongsTo {
        return $this->belongsTo(Partner::class);
    }

    /**
     * Relationship - course to discipline
     * @return BelongsTo
     */
    public function discipline(  ): BelongsTo {
        return $this->belongsTo(Discipline::class);
    }
}
