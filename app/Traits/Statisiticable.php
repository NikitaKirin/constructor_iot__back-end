<?php

namespace App\Traits;

use App\Models\EntityStat;

trait Statisiticable
{
    public function stats() {
        return $this->morphMany(EntityStat::class, 'entity');
    }
}
