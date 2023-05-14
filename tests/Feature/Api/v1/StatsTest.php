<?php

namespace Tests\Feature\Api\v1;

use App\Models\Course;
use App\Models\CourseAssembly;
use App\Models\EducationalProgram;
use App\Models\Profession;
use App\Models\ProfessionalTrajectory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StatsTest extends TestCase
{
    use RefreshDatabase;

    public function testStatStore() {
        $this->post(route('stat.store'), $this->getStatStoreData())
        ->assertStatus(201);
    }

    private function getStatStoreData(): array {
        $educationalProgramId = EducationalProgram::factory()->create()->first()->id;
        $courseAssemblyId = CourseAssembly::factory()->create()->first()->id;
        $professionalTrajectoryId = ProfessionalTrajectory::factory()->create()->first()->id;
        $professionId = Profession::factory()->create()->first()->id;
        $courseId = Course::factory()->create()->first()->id;
        return [
            "data" => [
                "educational_programs"      => [
                    [
                        "id"         => $educationalProgramId,
                        "event_type" => "click_in_constructor",
                        "created_at" => "2022-12-02 19:33:02",
                    ],
                    [
                        "id"         => $educationalProgramId,
                        "event_type" => "click_to_more",
                        "created_at" => "2022-12-02 19:33:02",
                    ],
                ],
                "course_assemblies"         => [
                    [
                        "id"         => $courseAssemblyId,
                        "event_type" => "click_in_constructor",
                        "created_at" => "2022-12-02 19:33:02",
                    ],
                    [
                        "id"         => $courseAssemblyId,
                        "event_type" => "click_to_more",
                        "created_at" => "2022-12-02 19:33:02",
                    ],
                    [
                        "id"         => $courseAssemblyId,
                        "event_type" => "click_in_constructor",
                        "created_at" => "2022-12-02 19:33:02",
                    ],
                    [
                        "id"         => $courseAssemblyId,
                        "event_type" => "click_to_more",
                        "created_at" => "2022-12-02 19:33:02",
                    ],
                    [
                        "id"         => $courseAssemblyId,
                        "event_type" => "click_in_constructor",
                        "created_at" => "2022-12-02 19:33:02",
                    ],
                    [
                        "id"         => $courseAssemblyId,
                        "event_type" => "click_to_more",
                        "created_at" => "2022-12-02 19:33:02",
                    ],
                ],
                "professional_trajectories" => [
                    [
                        "id"         => $professionalTrajectoryId,
                        "event_type" => "click_in_constructor",
                        "created_at" => "2022-12-02 19:32:02",
                    ],
                    [
                        "id"         => $professionalTrajectoryId,
                        "event_type" => "click_in_list",
                        "created_at" => "2022-12-02 19:32:02",
                    ],
                ],
                "professions"               => [
                    [
                        "id"         => $professionId,
                        "event_type" => "click_to_more",
                        "created_at" => "2022-12-02 19:33:02",
                    ],
                ],
                "partner_courses"           => [
                    [
                        "id"         => $courseId,
                        "event_type" => "click_to_more",
                        "created_at" => "2022-12-02 19:33:02",
                    ],
                    [
                        "id"         => $courseId,
                        "event_type" => "click_to_more",
                        "created_at" => "2022-12-02 19:33:02",
                    ],
                    [
                        "id"         => $courseId,
                        "event_type" => "click_to_more",
                        "created_at" => "2022-12-02 19:33:02",
                    ],
                ],
            ],
        ];
    }
}
