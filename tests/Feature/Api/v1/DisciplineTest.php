<?php

namespace Tests\Feature\Api\v1;

use App\Models\CourseAssembly;
use App\Models\EducationalProgram;
use App\Models\Discipline;
use App\Models\ProfessionalTrajectory;
use Database\Factories\EducationalProgramFactory;
use Database\Seeders\CourseAssemblyLevelSeeder;
use Database\Seeders\CourseAssemblySeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DisciplineTest extends TestCase
{
    use RefreshDatabase;

    public function testDisciplinesIndexAssertJsonStructure()
    {
        $disciplines = Discipline::factory(3)
            ->hasSemesters(2)
            ->hasCourseAssemblies(2)
            ->hasEducationalPrograms(1)
            ->create();

        $educationalProgram = $disciplines[0]->educationalPrograms()->first();

        $response = $this->get(route('disciplines.index', $educationalProgram));

        $response->assertStatus(200);

        $response->assertJsonStructure([
            'semesters' => [
                '*' => [
                    'id',
                    'text_representation',
                    'numerical_representation',
                    "disciplines" => [
                        '*' => [
                            'id',
                            'title',
                            'choice_limit',
                            'is_spec',
                            'course_assemblies' => [
                                '*' => [
                                    'id',
                                    'title',
                                    'description',
                                    'professional_trajectories' => [
                                        '*' => [
                                            'id',
                                            'title',
                                            'description',
                                            'slug',
                                            'color',
                                            'icons',
                                            'course_assembly_evaluation',
                                            'vacancies_count',
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ]);
    }

    public function testDisciplinesShowWithoutDisciplinesAssertJsonStructure()
    {
        $discipline = Discipline::factory(1)
            ->hasEducationalPrograms(1)
            ->create()
            ->first();

        $educationalProgram = $discipline->first()
            ->educationalPrograms
            ->first();
        $this->get(
            route(
                'disciplines.show',
                ['educationalProgram' => $educationalProgram->id, 'discipline' => $discipline->id]
            )
        )
            ->assertOk()
            ->assertJsonStructure([
                'discipline' => [
                    'id',
                    'title',
                    'choice_limit',
                    'is_spec',
                ],
            ]);
    }

    public function testDisciplinesShowWithDisciplinesAssertJsonStructure()
    {
        $this->seed(CourseAssemblySeeder::class);
        $this->seed(CourseAssemblyLevelSeeder::class);
        $professionalTrajectories = ProfessionalTrajectory::factory(2)->create();
        $discipline = Discipline::factory(1)
            ->hasEducationalPrograms(1)
            ->has(CourseAssembly::factory(2)->hasAttached($professionalTrajectories, ['course_assembly_level_digital_value' => 1]))
            ->create()
            ->first();

        $this->get(
            route(
                'disciplines.show',
                [
                    $discipline->id,
                    '?withCourseAssemblies=true',
                ]
            )
        )
            ->assertOk()
            ->assertJsonStructure([
                'discipline' => [
                    'id',
                    'title',
                    'choice_limit',
                    'is_spec',
                    'course_assemblies' => [
                        '*' => [
                            'id',
                            'title',
                            'description',
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
                    ],
                ],
            ]);
    }


    public function testDisciplinesShowWithNonExistingEducationalModule()
    {
        $this->get(
            route('disciplines.show', ['discipline' => 1]
            )
        )
            ->assertStatus(404);
    }
}
