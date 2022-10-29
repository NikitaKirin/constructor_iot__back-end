<?php

namespace App\Models;

use App\Traits\Userable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Orchid\Screen\AsSource;

class SocialNetworksBlock extends Model
{
    use SoftDeletes, AsSource, Userable, HasFactory;

    protected $fillable = [
        'data->vk->url',
        'data->telegram->url',
    ];

    protected $casts = [
        'data' => 'array',
    ];

    /**
     * Relationship institute to user
     * @return BelongsTo
     */
    public function institute(): BelongsTo {
        return $this->belongsTo(Institute::class);
    }
}
