<?php

namespace App\Models;

use App\Traits\Userable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Orchid\Screen\AsSource;

class SocialNetworksBlock extends Model
{
    use SoftDeletes, AsSource, Userable;

    protected $fillable = [
        'data',
    ];

    /**
     * Relationship institute to user
     * @return BelongsTo
     */
    public function institute(): BelongsTo {
        return $this->belongsTo(Institute::class);
    }
}
