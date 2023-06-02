<?php

namespace App\Http\Controllers\Api\v1;

use App\Actions\EntityStat\DTO\StoreEntityStatData;
use App\Actions\EntityStat\StoreCourseAssembliesStatAction;
use App\Actions\EntityStat\StoreEducationalProgramsStatAction;
use App\Actions\EntityStat\StoreEntityStatRecordsAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\EntityStat\StoreEntityStatRequest;
use App\Models\Course;
use App\Models\CourseAssembly;
use App\Models\EducationalProgram;
use App\Models\Profession;
use App\Models\ProfessionalTrajectory;

class EntityStatController extends Controller
{
    public function store(StoreEntityStatRequest $request) {
        $validated = collect($request->validated()['data']);
        if ($educationalPrograms = $validated->get('educational_programs')) {
            $educationalProgramsData = collect($educationalPrograms)->map(
                fn($educationalProgram) => $this->createEntityStatData($educationalProgram, EducationalProgram::class)
            )->toArray();
            (new StoreEntityStatRecordsAction())->run($educationalProgramsData);
        }
        if ($courseAssemblies = $validated->get('course_assemblies')) {
            $courseAssembliesData = collect($courseAssemblies)->map(
                fn($courseAssembly) => $this->createEntityStatData($courseAssembly, CourseAssembly::class)
            )->toArray();
            (new StoreEntityStatRecordsAction())->run($courseAssembliesData);
        }
        if ($professionalTrajectories = $validated->get('professional_trajectories')) {
            $professionalTrajectoriesData = collect($professionalTrajectories)->map(
                fn($professionalTrajectory) => $this->createEntityStatData($professionalTrajectory, ProfessionalTrajectory::class)
            )->toArray();
            (new StoreEntityStatRecordsAction())->run($professionalTrajectoriesData);
        }
        if ($professions = $validated->get('professions')) {
            $professionsData = collect($professions)->map(
                fn($profession) => $this->createEntityStatData($profession, Profession::class)
            )->toArray();
            (new StoreEntityStatRecordsAction())->run($professionsData);
        }
        if ($partnerCourses = $validated->get('partner_courses')) {
            $partnerCoursesData = collect($partnerCourses)->map(
                fn($partnerCourse) => $this->createEntityStatData($partnerCourse, Course::class)
            )->toArray();
            (new StoreEntityStatRecordsAction())->run($partnerCoursesData);
        }
        return response()->json([
            'message'=> 'Data has been saved'
        ], 201);
    }

    private function createEntityStatData(array $entityData, string $entityType) {
        return new StoreEntityStatData(
            entity_type: $entityType,
            entity_id: $entityData['id'],
            event_type: $entityData['event_type'],
            educational_program_id: $entityData['educational_program_id'] ?? null,
            created_at: $entityData['created_at']
        );
    }
}
