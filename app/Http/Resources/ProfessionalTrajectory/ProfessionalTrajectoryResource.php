<?php

namespace App\Http\Resources\ProfessionalTrajectory;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\ProfessionalTrajectory */
class ProfessionalTrajectoryResource extends JsonResource
{
    public static $wrap = 'professional_trajectory';

    /**
     * @param Request $request
     * @return array
     */
    public function toArray( $request ) {
        return [
            'id'          => $this->id,
            'title'       => $this->title,
            'description' => $this->description,
            'color'       => $this->color,
            //'disciplines' => DisciplineResourceCollection::collection($this->whenLoaded('disciplines')),
        ];
    }
}
