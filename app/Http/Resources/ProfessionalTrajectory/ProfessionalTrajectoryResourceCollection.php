<?php

namespace App\Http\Resources\ProfessionalTrajectory;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

/** @see \App\Models\ProfessionalTrajectory */
class ProfessionalTrajectoryResourceCollection extends ResourceCollection
{
    public static $wrap = 'professional_trajectories';

    /**
     * @param Request $request
     * @return array
     */
    public function toArray( $request ) {
        return [
            'professional_trajectories' => $this->collection,
        ];
    }
}
