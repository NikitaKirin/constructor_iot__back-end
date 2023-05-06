<?php

namespace App\Actions\EntityStat\DTO;

class StoreEntityStatData
{

    public function __construct(
        public readonly string $entity_type,
        public readonly int    $entity_id,
        public readonly string $event_type,
        public readonly string $created_at
    ) {
    }

}
