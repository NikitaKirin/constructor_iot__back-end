<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class FrequentlyAskedQuestion extends Model
{
    use HasFactory, use SoftDeletes;

    protected $fillable = [
        'question',
        'answer',
    ];

    /**
     * Relationship - frequently asked question to user
     * @return BelongsTo
     */
    public function user(  ): BelongsTo {
        return  $this->belongsTo(User::class);
    }
}
