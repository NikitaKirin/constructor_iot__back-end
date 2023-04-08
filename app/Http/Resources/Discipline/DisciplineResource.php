<?php

namespace App\Http\Resources\Discipline;

use App\Http\Resources\CourseAssembly\CourseAssemblyResource;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\Discipline */
class DisciplineResource extends JsonResource
{
    public static $wrap = 'discipline';

    /**
     * @param  Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'choice_limit' => $this->choice_limit,
            'is_spec' => $this->is_spec,
            'course_assemblies' => $this->whenLoaded('courseAssemblies', fn() => $this->getCourseAssemblies($request)),
        ];
    }


    /**
     * Get the list of course assemblies
     * @param  Request  $request
     * @return AnonymousResourceCollection
     */
    private function getCourseAssemblies(Request $request): AnonymousResourceCollection
    {
        if (($professionalTrajectoryId = $request->input('professionalTrajectoryId')) && $this->is_spec) {
            return CourseAssemblyResource::collection(
                $this->courseAssemblies()->whereHas(
                    'professionalTrajectories',
                    function (Builder $query) use ($professionalTrajectoryId) {
                        return $query->where('id', '=', $professionalTrajectoryId);
                    }
                )->with('professionalTrajectories')->orderBy('title')->get()
            );
        }
        return CourseAssemblyResource::collection($this->courseAssemblies);
    }
}
