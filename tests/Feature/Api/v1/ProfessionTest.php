<?php

namespace Tests\Feature\Api\v1;

use App\Models\Profession;
use App\Models\ProfessionalTrajectory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class ProfessionTest extends TestCase
{
    use RefreshDatabase;

    public function testProfessionsIndexAssertJsonStructure() {
        Profession::factory()->hasProfessionalTrajectories()->create();
        $this->get(route('professions.index'))
            ->assertOk()
            ->assertJsonStructure([
                'professions' => [
                    '*' => [
                        'id',
                        'title',
                        'description',
                        'vacancies_count',
                        'area_vacancies_count',
                        'maximal_salary',
                        'minimal_salary',
                        'median_salary',
                        'professionalTrajectories' => [
                            '*' => [
                                'id',
                                'title',
                                'description',
                                'abbreviated_name',
                                'color',
                            ],
                        ],
                    ],
                ],
            ]);
    }

    public function testProfessionsIndexAssertJsonValue() {
        $profession = Profession::factory()->hasProfessionalTrajectories()->create()->first();
        $professionalTrajectory = ProfessionalTrajectory::first();
        $this->get(route('professions.index'))
            ->assertOk()
            ->assertJson(fn(AssertableJson $json) => $json->has(
                'professions.0',
                fn(AssertableJson $json) => $json->where('id', $profession->id)
                    ->where('title', $profession->title)
                    ->where('description', $profession->description)
                    ->where('vacancies_count', $profession->vacancies_count)
                    ->where('area_vacancies_count', $profession->area_vacancies_count)
                    ->where('maximal_salary', $profession->maximal_salary)
                    ->where('minimal_salary', $profession->minimal_salary)
                    ->where('median_salary', $profession->median_salary)
                    ->has('professionalTrajectories.0', fn(AssertableJson $json) => $json->where('id', $professionalTrajectory->id)
                        ->where('title', $professionalTrajectory->title)
                        ->where('description', $professionalTrajectory->description)
                        ->where('abbreviated_name', $professionalTrajectory->abbreviated_name)
                        ->where('color', $professionalTrajectory->color)
                    )->etc()
            )->etc()
            );
    }

    public function testProfessionsShowAssertJsonStructure() {
        $profession = Profession::factory()->create()->first();
        $this->get(route('professions.show', [$profession]))
            ->assertOk()
            ->assertJsonStructure([
                'profession' => [
                    'id',
                    'title',
                    'description',
                    'vacancies_count',
                    'area_vacancies_count',
                    'maximal_salary',
                    'minimal_salary',
                    'median_salary',
                    'photo',
                ],
            ]);
    }

    public function testProfessionsShowAssertJsonValue() {
        $profession = Profession::factory()->create()->first();
        $this->get(route('professions.show', [$profession]))
            ->assertOk()
            ->assertJson(fn(AssertableJson $json) => $json->has(
                'profession',
                fn(AssertableJson $json) => $json->where('id', $profession->id)
                    ->where('title', $profession->title)
                    ->where('description', $profession->description)
                    ->where('vacancies_count', $profession->vacancies_count)
                    ->where('area_vacancies_count', $profession->area_vacancies_count)
                    ->where('maximal_salary', $profession->maximal_salary)
                    ->where('minimal_salary', $profession->minimal_salary)
                    ->where('median_salary', $profession->median_salary)
                    ->etc()
            )->etc()
            );
    }

    public function testProfessionsWithProfessionalTrajectoriesShowAssertJsonStructure() {
        $profession = Profession::factory()->hasProfessionalTrajectories()->create()->first();
        $this->get(route('professions.show', [$profession, 'withProfessionalTrajectories=true']))
            ->assertOk()
            ->assertJsonStructure([
                'profession' => [
                    'id',
                    'title',
                    'description',
                    'vacancies_count',
                    'area_vacancies_count',
                    'maximal_salary',
                    'minimal_salary',
                    'median_salary',
                    'photo',
                    'professionalTrajectories' => [
                        '*' => [
                            'id',
                            'title',
                            'description',
                            'abbreviated_name',
                            'color',
                        ],
                    ],
                ],
            ]);
    }

    public function testProfessionsWithProfessionalTrajectoriesShowAssertJsonValue() {
        $profession = Profession::factory()->hasProfessionalTrajectories()->create()->first();
        $professionalTrajectory = ProfessionalTrajectory::first();
        $this->get(route('professions.show', [$profession, 'withProfessionalTrajectories=true']))
            ->assertOk()
            ->assertJson(fn(AssertableJson $json) => $json->has(
                'profession',
                fn(AssertableJson $json) => $json->where('id', $profession->id)
                    ->where('title', $profession->title)
                    ->where('description', $profession->description)
                    ->where('vacancies_count', $profession->vacancies_count)
                    ->where('area_vacancies_count', $profession->area_vacancies_count)
                    ->where('maximal_salary', $profession->maximal_salary)
                    ->where('minimal_salary', $profession->minimal_salary)
                    ->where('median_salary', $profession->median_salary)
                    ->has('professionalTrajectories.0', fn(AssertableJson $json) => $json
                        ->where('id', $professionalTrajectory->id)
                        ->where('title', $professionalTrajectory->title)
                        ->where('description', $professionalTrajectory->description)
                        ->where('abbreviated_name', $professionalTrajectory->abbreviated_name)
                        ->where('color', $professionalTrajectory->color)
                        ->etc()
                    )->etc()
            )
            );
    }
}
