<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Course\CourseResource;
use App\Http\Resources\Course\CourseResourceCollection;
use App\Http\Resources\Partner\PartnerResourceCollection;
use App\Models\Course;
use App\Models\Partner;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class PartnerController extends Controller
{
    /**
     * Получить список всех партнёров
     * Get the list of the partners
     * @return PartnerResourceCollection
     */
    public function index(Request $request) {
        $partnerBuilder = Partner::query()->orderBy('title');
        if ($paginate = $request->input('paginate', default: false)){
            return new PartnerResourceCollection($partnerBuilder->paginate($paginate));
        }
        return new PartnerResourceCollection($partnerBuilder->get());
    }

    /**
     * Получить список партнерских курсов
     * Get the list of the partners' courses
     * @param Request $request
     * @return CourseResourceCollection
     */
    public function coursesIndex(Request $request) {
        $paginate = $request->integer('paginate', default: 18);
        $courseBuilder = Course::with([
            'courseAssembly.professionalTrajectories',
            'partner.logo',
            'realization',
        ])->has('partner');
        if ($courseTitle = $request->input('courseTitle', default: false)) {
            $courseBuilder->where('title', 'ilike', "%${courseTitle}%");
        }
        if ($educationalProgramms = $request->input('educationalProgramms', default: false)) {
            $courseBuilder->whereHas('courseAssembly.disciplines.educationalPrograms',
                fn(Builder $builder) => $builder->whereIntegerInRaw('id', $educationalProgramms));
        }
        if ($partners = $request->input('partners', default: false)) {
            $courseBuilder->whereHas('partner',
                fn(Builder $builder) => $builder->whereIntegerInRaw('id', $partners));
        }
        if ($professionalTrajectories = $request->input('professionalTrajectories', default: false)) {
            $courseBuilder->whereHas('discipline.professionalTrajectories',
                fn(Builder $builder) => $builder->whereIntegerInRaw('id', $professionalTrajectories));
        }
        return new CourseResourceCollection($courseBuilder->paginate($paginate));
    }

    public function courseShow(Course $course) {
        return new CourseResource($course->load([
            'realization',
            'courseAssembly.professionalTrajectories',
            'courseAssembly.disciplines.educationalPrograms',
            'attachment',
            'partner',
        ]));
    }
}
