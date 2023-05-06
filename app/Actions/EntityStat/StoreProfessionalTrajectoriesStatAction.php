<?php

namespace App\Actions\EntityStat;

class StoreProfessionalTrajectoriesStatAction
{
    public function run(array $educationalProgramsData): bool {
        $resultRecords = collect($educationalProgramsData)->map(function (StoreEntityStatData $educationalProgramData){
            return [
                'entity_type' => $educationalProgramData->entity_type,
                'entity_id' => $educationalProgramData->entity_id,
                'event_type' => $educationalProgramData->event_type,
                'created_at' => $educationalProgramData->created_at,
            ];
        })->toArray();
        return EntityStat::insert($resultRecords);
    }
}
