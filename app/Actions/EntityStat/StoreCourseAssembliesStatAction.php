<?php

namespace App\Actions\EntityStat;

use App\Actions\EntityStat\DTO\StoreEntityStatData;
use App\Models\EntityStat;

class StoreCourseAssembliesStatAction
{

    public function run(array $courseAssembliesData): bool {
        $resultRecords = collect($courseAssembliesData)->map(function (StoreEntityStatData $courseAssemblyData){
            return [
                'entity_type' => $courseAssemblyData->entity_type,
                'entity_id' => $courseAssemblyData->entity_id,
                'event_type' => $courseAssemblyData->event_type,
                'created_at' => $courseAssemblyData->created_at,
            ];
        })->toArray();
        return EntityStat::insert($resultRecords);
    }
}
