<?php

namespace App\Actions\EntityStat;

use App\Actions\EntityStat\DTO\StoreEntityStatData;
use App\Models\EntityStat;

class StoreEntityStatRecordsAction
{
    public function run(array $entityStatsData): bool {
        $resultRecords = collect($entityStatsData)->map(function (StoreEntityStatData $entityStatData){
            return [
                'entity_type' => $entityStatData->entity_type,
                'entity_id' => $entityStatData->entity_id,
                'event_type' => $entityStatData->event_type,
                'created_at' => $entityStatData->created_at,
            ];
        })->toArray();
        return EntityStat::insert($resultRecords);
    }
}
