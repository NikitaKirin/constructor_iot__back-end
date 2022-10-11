<?php

namespace App\Traits;

use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait Userable
{
    /**
     * Relationship - educational module to user
     * @return BelongsTo
     */
    public function user(): BelongsTo {
        return $this->belongsTo(User::class)->withDefault(['name' => __("Не определено")]);
    }
}
