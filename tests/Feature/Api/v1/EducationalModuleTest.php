<?php

namespace Tests\Feature\Api\v1;

use App\Models\EducationalDirection;
use App\Models\EducationalModule;
use Database\Factories\EducationalDirectionFactory;
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
            ->hasEducationalDirections(1)
            ->create();

        $educationalDirection = $educationalModules[0]->educationalDirections()->first();

        $response = $this->get(route('educationalModules.index', $educationalDirection));

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
                                            'sum_disciplines_levels_points',
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
}