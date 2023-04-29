<?php

namespace App\Http\Resources\Profession;

use App\Http\Resources\EducationalProgram\EducationalProgramResource;
use App\Http\Resources\ProfessionalTrajectory\ProfessionalTrajectoryResource;
use App\Models\CourseAssembly;
use App\Models\EducationalProgram;
use App\Models\Profession;
use App\Models\ProfessionalTrajectory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;

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
                function () {
                    $professionalTrajectories = $this->professionalTrajectories;
                    $educationalPrograms = collect($professionalTrajectories)->map(function (ProfessionalTrajectory $professionalTrajectory) {
                        $courseAssemblies = $professionalTrajectory->courseAssemblies;
                        return collect($courseAssemblies)->map(function (CourseAssembly $courseAssembly) {
                            return $courseAssembly->discipline->educationalPrograms;
                        })->first();
                    })->first();
                    if ($educationalPrograms->count() > 0) {
                        return EducationalProgramResource::collection(collect($educationalPrograms)->unique('id'));
                    }
                    return [];
                }),
        ];
    }

    private function getEducationalPrograms(): AnonymousResourceCollection {
        return EducationalProgramResource::collection(EducationalProgram::whereHas('disciplines.courseAssemblies.professionalTrajectories.professions',
            function (Builder $builder) {
                $builder->where('id', $this->id);
            })->get());
    }
}
