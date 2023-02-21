<?php

namespace App\Http\Resources\Profession;

use App\Http\Resources\ProfessionalTrajectory\ProfessionalTrajectoryResource;
use App\Http\Resources\ProfessionalTrajectory\ProfessionalTrajectoryResourceCollection;
use App\Models\Profession;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Config;

/** @mixin Profession */
class ProfessionResource extends JsonResource
{
    public static $wrap = 'profession';

    /**
     * @param Request $request
     * @return array
     */
    public function toArray($request) {
        return [
            'id'                              => $this->id,
            'title'                           => $this->title,
            'description'                     => $this->description,
            'vacancies_count'                 => $this->vacancies_count,
            'maximal_salary'                  => $this->maximal_salary,
            'minimal_salary'                  => $this->minimal_salary,
            'median_salary'                   => $this->median_salary,
            'photo'                           => $this->photo->url() ?? Config::get('constants.avatars.employee.url'),
            'professional_trajectories_count' => $this->whenCounted('professionalTrajectories'),
            'professionalTrajectories'        => ProfessionalTrajectoryResource::collection($this->whenLoaded('professionalTrajectories')),
        ];
    }
}
