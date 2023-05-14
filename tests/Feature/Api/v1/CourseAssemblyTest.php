<?php

namespace Tests\Feature\Api\v1;

use App\Models\Course;
use App\Models\CourseAssembly;
use App\Models\CourseAssemblyLevel;
use App\Models\ProfessionalTrajectory;
use Database\Factories\ProfessionalTrajectoryFactory;
use Database\Seeders\CourseAssemblyLevelSeeder;
use Database\Seeders\CourseAssemblySeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Config;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class CourseAssemblyTest extends TestCase
{
    use RefreshDatabase;

    public function testCourseAssembliesShowAssertJsonStructure() {
        $this->seed(CourseAssemblySeeder::class);
        $this->seed(CourseAssemblyLevelSeeder::class);
        $professionalTrajectories = ProfessionalTrajectory::factory(2)->create();
        $courseAssemblies = CourseAssembly::factory(5)
            ->hasAttached($professionalTrajectories, ['course_assembly_level_digital_value' => 1])
            ->hasCourses(3)
            ->create();
        $courseAssembly = $courseAssemblies->first()
            ->load(['courses', 'courses.partner', 'courses.realization']);
        $response = $this->get(route('courseAssemblies.show', $courseAssembly));
        $response->assertOk()
            ->assertJsonStructure([
                    'course_assembly' => [
                        'id',
                        'title',
                        'description',
                        'courses'                   => [
                            '*' => [
                                'id',
                                'title',
                                'description',
                                'realization',
                                'partner' => [
                                    'id',
                                    'title',
                                    'logo',
                                ],
                            ],
                        ],
                        'professional_trajectories' => [
                            '*' => [
                                'id',
                                'title',
                                'description',
                                'abbreviated_name',
                                'color',
                                'course_assembly_evaluation',
                            ],
                        ],
                    ],
                ]
            );
    }

    public function testCourseAssembliesShowAssertJsonValue() {
        $this->seed(CourseAssemblySeeder::class);
        $this->seed(CourseAssemblyLevelSeeder::class);
        $professionalTrajectories = ProfessionalTrajectory::factory(2)->create();
        $courseAssemblies = CourseAssembly::factory(5)
            ->hasAttached($professionalTrajectories, ['course_assembly_level_digital_value' => 1])
            ->hasCourses(3)
            ->create();
        $courseAssembly = $courseAssemblies->first()
            ->load(['courses', 'courses.partner', 'courses.realization']);
        $course = $courseAssembly->courses()->first()->load('partner');
        $partner = $course->partner;
        $professionalTrajectory = $courseAssembly->professionalTrajectories()->first();
        $response = $this->get(route('courseAssemblies.show', $courseAssembly));
        $response->assertOk()
            ->assertJson(
                fn(AssertableJson $json) => $json->has(
                    'course_assembly',
                    fn(AssertableJson $json) => $json->where('id', $courseAssembly->id)
                        ->where('title', $courseAssembly->title)
                        ->where('description', $courseAssembly->description)
                        ->has('courses', 3, fn(AssertableJson $json) => $json->where('id', $course->id)
                            ->where('title', $course->title)
                            ->where('description', $course->description)
                            ->where('realization', $course->realization->title)
                            ->has('partner', fn(AssertableJson $json) => $json->where('id', $partner->id)
                                ->where('title', $partner->title)
                                ->where('site_link', $partner->site_link)
                                ->where(
                                    'logo',
                                    $partner->logo?->url() ?? asset(Config::get('constants.avatars.employee.url'))
                                )
                            ))
                        ->has(
                            'professional_trajectories', 2,
                            fn(AssertableJson $json) => $json->where('id', $professionalTrajectory->id)
                                ->where('title', $professionalTrajectory->title)
                                ->where('description', $professionalTrajectory->description)
                                ->where('abbreviated_name', $professionalTrajectory->abbreviated_name)
                                ->where('color', $professionalTrajectory->color)
                                ->where(
                                    'course_assembly_evaluation',
                                    $professionalTrajectory->pivot->course_assembly_level_digital_value
                                )
                                ->etc()
                        )
                )
            );
    }

    public function testCourseAssembliesNonExistingShow() {
        $courseAssembly = CourseAssembly::factory(5)
                ->create()
                ->last()
                ->id + 100;

        $this->get(route('courseAssemblies.show', $courseAssembly))
            ->assertStatus(404);
    }
}
