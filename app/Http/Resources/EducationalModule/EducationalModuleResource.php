<?php

namespace App\Http\Resources\EducationalModule;

use App\Http\Resources\Discipline\DisciplineResource;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\EducationalModule */
class EducationalModuleResource extends JsonResource
{
    public static $wrap = 'educational_module';

    /**
     * @param  Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'choice_limit' => $this->choice_limit,
            'is_spec' => $this->is_spec,
            //            'disciplines_count'            => $this->disciplines_count,
            //            'educational_directions_count' => $this->educational_directions_count,
            //'semesters_count'              => $this->semesters_count,
            'disciplines' => $this->whenLoaded('disciplines', fn() => $this->getDisciplines($request)),


            /*'educationalDirections' => EducationalDirectionResourceCollection::collection($this->whenLoaded('educationalDirections')),*/
        ];
    }


    /**
     * Get the list of disciplines
     * @param  Request  $request
     * @return AnonymousResourceCollection
     */
    private function getDisciplines(Request $request): AnonymousResourceCollection
    {
        if (($professionalTrajectoryId = $request->input('professionalTrajectoryId')) && $this->is_spec) {
            return DisciplineResource::collection(
                $this->disciplines()->whereHas(
                    'professionalTrajectories',
                    function (Builder $query) use ($professionalTrajectoryId) {
                        return $query->where('id', '=', $professionalTrajectoryId);
                    }
                )->with('professionalTrajectories')->orderBy('title')->get()
            );
        }
        return DisciplineResource::collection($this->disciplines);
    }
}
