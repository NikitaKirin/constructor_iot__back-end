<?php

namespace App\Actions\EntityStat;

use App\Actions\EntityStat\DTO\StoreEntityStatData;
use App\Models\EducationalProgram;
use App\Models\EntityStat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StoreEducationalProgramsStatAction
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
