<?php

namespace App\Http\Resources\Discipline;

use App\Http\Resources\Course\CourseResource;
use App\Http\Resources\ProfessionalTrajectory\ProfessionalTrajectoryResource;
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
            'id'                        => $this->id,
            'title'                     => $this->title,
            'description'               => $this->description,
            /*'courses_count'                   => $this->courses_count,
            'educational_modules_count'       => $this->educational_modules_count,
            'professional_trajectories_count' => $this->professional_trajectories_count,*/
            'courses'                   => $this->whenLoaded('courses', CourseResource::collection($this->courses()
                                                                                                        ->orderBy('title')
                                                                                                        ->get())),
            /*'professional_trajectories' => ProfessionalTrajectoryResource::collection($this->professionalTrajectories
            ()->orderBy('title')->get()),*/
            'professional_trajectories' => $this->when($this->professionalTrajectories()->exists(), function () {
                return ProfessionalTrajectoryResource::collection($this->professionalTrajectories);
            })

            /*'educationalModules' => EducationalModuleResourceCollection::collection($this->whenLoaded('educationalModules')),*/
        ];
    }
}
