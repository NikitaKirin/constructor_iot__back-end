<?php

namespace App\Http\Resources\EducationalModule;

use App\Http\Resources\Discipline\DisciplineResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\EducationalModule */
class EducationalModuleResource extends JsonResource
{
    public static $wrap = 'educational_module';

    /**
     * @param Request $request
     * @return array
     */
    public function toArray( $request ) {
        return [
            'id'           => $this->id,
            'title'        => $this->title,
            'choice_limit' => $this->choice_limit,
            //            'disciplines_count'            => $this->disciplines_count,
            //            'educational_directions_count' => $this->educational_directions_count,
            //'semesters_count'              => $this->semesters_count,
            'disciplines'  => $this->whenLoaded('disciplines', function () {
                return DisciplineResource::collection($this->disciplines()->orderBy('title')->get());
            }),

            /*'educationalDirections' => EducationalDirectionResourceCollection::collection($this->whenLoaded('educationalDirections')),*/
        ];
    }
}
