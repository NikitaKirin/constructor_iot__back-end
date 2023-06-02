<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Orchid\Metrics\Chartable;

class EntityStat extends Model
{
    use Chartable;

    protected $fillable = [
        'entity_id',
        'entity_type',
        'event_type',
        'educational_program_id',
        'created_at',
    ];

    public function statisticable(): MorphTo {
        return $this->morphTo();
    }

    protected $casts = [
        'stat' => 'array',
    ];

}
