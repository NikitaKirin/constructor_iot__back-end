<?php

namespace App\Http\Resources\CourseAssembly;

use App\Http\Resources\Course\CourseResource;
use App\Http\Resources\ProfessionalTrajectory\ProfessionalTrajectoryResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\CourseAssembly */
class CourseAssemblyResource extends JsonResource
{
    public static $wrap = 'course_assembly';

    /**
     * @param Request $request
     * @return array
     */
    public function toArray( $request ) {
        return [
            'id'                        => $this->id,
            'title'                     => $this->title,
            'description'               => $this->description,
            'courses'                   => CourseResource::collection($this->whenLoaded('courses')),
            'professional_trajectories' => ProfessionalTrajectoryResource::collection($this->whenLoaded('professionalTrajectories')),
        ];
    }
}
