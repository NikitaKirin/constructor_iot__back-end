<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * Relationship - employee to user
     * @return BelongsTo
     */
    public function user(  ): BelongsTo {
        return $this->belongsTo(User::class);
    }

    /**
     * Relationship - employee to position
     * @return BelongsTo
     */
    public function position(  ): BelongsTo {
        return $this->belongsTo(Position::class);
    }
}
