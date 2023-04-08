<?php

namespace App\Http\Resources\ProfessionalTrajectory;

use App\Http\Resources\Profession\ProfessionResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Collection;
use Orchid\Attachment\Models\Attachment;

/** @mixin \App\Models\ProfessionalTrajectory */
class ProfessionalTrajectoryResource extends JsonResource
{
    public static $wrap = 'professional_trajectory';

    /**
     * @param Request $request
     * @return array
     */
    public function toArray($request) {
        return [
            'id'                    => $this->id,
            'title'                 => $this->title,
            'description'           => $this->description,
            'abbreviated_name'      => $this->abbreviated_name,
            'color'                 => $this->color,
            'icons'                 => $this->whenLoaded('icons', function () {
                return collect($this->icons)->map(fn(Attachment $img) => $img->url());
            }),
            'course_assembly_evaluation' => $this->whenPivotLoaded('course_assembly_professional_trajectory', function () {
                return $this->pivot->course_assembly_level_digital_value;
            }),
            'amount_vacancies'      => $this->whenLoaded('professions', function () {
                return $this->professions->sum('vacancies_count');
            }),
            'course_assemblies_count'     => $this->whenCounted('courseAssemblies'),
            'professions'           => ProfessionResource::collection($this->whenLoaded('professions')),
        ];
    }
}
