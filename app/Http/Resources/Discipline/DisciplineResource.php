<?php

namespace App\Http\Resources\Discipline;

use App\Http\Resources\Course\CourseResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\Discipline */
class DisciplineResource extends JsonResource
{
    public static $wrap = 'discipline';

    /**
     * @param Request $request
     * @return array
     */
    public function toArray( $request ) {
        return [
            'id'          => $this->id,
            'title'       => $this->title,
            'description' => $this->description,
            /*'courses_count'                   => $this->courses_count,
            'educational_modules_count'       => $this->educational_modules_count,
            'professional_trajectories_count' => $this->professional_trajectories_count,*/
            'courses'     => CourseResource::collection($this->courses()->orderBy('title')->get()),

            /*'educationalModules' => EducationalModuleResourceCollection::collection($this->whenLoaded('educationalModules')),*/
        ];
    }
}
