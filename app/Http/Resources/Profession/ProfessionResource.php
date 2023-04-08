<?php

namespace App\Http\Resources\Profession;

use App\Http\Resources\EducationalProgram\EducationalProgramResource;
use App\Http\Resources\EducationalProgram\EducationalProgramResourceCollection;
use App\Http\Resources\ProfessionalTrajectory\ProfessionalTrajectoryResource;
use App\Http\Resources\ProfessionalTrajectory\ProfessionalTrajectoryResourceCollection;
use App\Models\EducationalProgram;
use App\Models\Profession;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
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
            'id'                       => $this->id,
            'title'                    => $this->title,
            'description'              => $this->description,
            'vacancies_count'          => $this->vacancies_count,
            'area_vacancies_count'     => $this->area_vacancies_count,
            'maximal_salary'           => $this->maximal_salary,
            'minimal_salary'           => $this->minimal_salary,
            'median_salary'            => $this->median_salary,
            'photo'                    => $this->photo->url(),
            'professionalTrajectories' => ProfessionalTrajectoryResource::collection($this->whenLoaded('professionalTrajectories')),
            'educationalPrograms'      => $this->when($request->boolean('withEducationalPrograms'),
                fn() => $this->getEducationalPrograms()),
        ];
    }

    private function getEducationalPrograms(): AnonymousResourceCollection {
        return EducationalProgramResource::collection(EducationalProgram::whereHas('disciplines.courseAssemblies.professionalTrajectories.professions',
            function (Builder $builder) {
                $builder->where('id', $this->id);
            })->get());
    }
}
