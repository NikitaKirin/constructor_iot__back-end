<?php

namespace Tests\Feature\Api\v1;

use App\Models\Discipline;
use App\Models\EducationalProgram;
use App\Models\EducationalModule;
use App\Models\ProfessionalTrajectory;
use Database\Factories\EducationalProgramFactory;
use Database\Seeders\DisciplineLevelSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EducationalModuleTest extends TestCase
{
    use RefreshDatabase;

    public function testEducationalModuleIndexAssertJsonStructure()
    {
        $educationalModules = EducationalModule::factory(3)
            ->hasSemesters(2)
            ->hasDisciplines(2)
            ->hasEducationalPrograms(1)
            ->create();

        $educationalProgram = $educationalModules[0]->educationalPrograms()->first();

        $response = $this->get(route('educationalModules.index', $educationalProgram));

        $response->assertStatus(200);

        $response->assertJsonStructure([
            'semesters' => [
                '*' => [
                    'id',
                    'text_representation',
                    'numerical_representation',
                    "educationalModules" => [
                        '*' => [
                            'id',
                            'title',
                            'choice_limit',
                            'is_spec',
                            'disciplines' => [
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
                                            'discipline_evaluation',
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

    public function testEducationalModulesShowWithoutDisciplinesAssertJsonStructure()
    {
        $educationalModule = EducationalModule::factory(1)
            ->hasEducationalPrograms(1)
            ->create()
            ->first();

        $educationalProgram = $educationalModule->first()
            ->educationalPrograms
            ->first();
        $this->get(
            route(
                'educationalModules.show',
                ['educationalProgram' => $educationalProgram->id, 'educationalModule' => $educationalModule->id]
            )
        )
            ->assertOk()
            ->assertJsonStructure([
                'educational_module' => [
                    'id',
                    'title',
                    'choice_limit',
                    'is_spec',
                ],
            ]);
    }

    public function testEducationalModuleShowWithDisciplinesAssertJsonStructure()
    {
        $this->seed(DisciplineLevelSeeder::class);
        $professionalTrajectories = ProfessionalTrajectory::factory(2)->create();
        $educationalModule = EducationalModule::factory(1)
            ->hasEducationalPrograms(1)
            ->has(Discipline::factory(2)->hasAttached($professionalTrajectories, ['discipline_level_digital_value' => 1]))
            ->create()
            ->first();

        $this->get(
            route(
                'educationalModules.show',
                [
                    $educationalModule->id,
                    '?withDisciplines=true',
                ]
            )
        )
            ->assertOk()
            ->assertJsonStructure([
                'educational_module' => [
                    'id',
                    'title',
                    'choice_limit',
                    'is_spec',
                    'disciplines' => [
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
                                    'discipline_evaluation',
                                ],
                            ],
                        ],
                    ],
                ],
            ]);
    }


    public function testEducationalModuleShowWithNonExistingEducationalModule()
    {
        $this->get(
            route('educationalModules.show', ['educationalModule' => 1]
            )
        )
            ->assertStatus(404);
    }
}
