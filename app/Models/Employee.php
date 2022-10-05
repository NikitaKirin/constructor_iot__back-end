<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Orchid\Attachment\Attachable;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class Employee extends Model
{
    use HasFactory, SoftDeletes, AsSource, Attachable, Filterable;


    protected $fillable = [
        'full_name',
        'email',
        'phone_number',
        'address',
        'audience',
        'additional_information',
        'position_id',
    ];

    protected $allowedSorts = [
        'full_name',
        'created_at',
        'updated_at',
    ];

    /**
     * Relationship - employee to user
     * @return BelongsTo
     */
    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }

    /**
     * Relationship - employee to position
     * @return BelongsTo
     */
    public function position(): BelongsTo {
        return $this->belongsTo(Position::class);
    }
}
