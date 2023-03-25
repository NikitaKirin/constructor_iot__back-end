<?php

namespace Tests\Feature\Api\v1;

use App\Models\Course;
use App\Models\Discipline;
use App\Models\DisciplineLevel;
use App\Models\ProfessionalTrajectory;
use Database\Factories\ProfessionalTrajectoryFactory;
use Database\Seeders\DisciplineLevelSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Config;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class DisciplineTest extends TestCase
{
    use RefreshDatabase;

    public function testDisciplinesShowAssertJsonStructure() {
        $this->seed(DisciplineLevelSeeder::class);
        $professionalTrajectories = ProfessionalTrajectory::factory(2)->create();
        $disciplines = Discipline::factory(5)
            ->hasAttached($professionalTrajectories, ['discipline_level_digital_value' => 1])
            ->hasCourses(3)
            ->create();
        $discipline = $disciplines->first()
            ->load(['courses', 'courses.partner', 'courses.realization']);
        $response = $this->get(route('disciplines.show', $discipline));
        $response->assertOk()
            ->assertJsonStructure([
                    'discipline' => [
                        'id',
                        'title',
                        'description',
                        'courses'                   => [
                            '*' => [
                                'id',
                                'title',
                                'description',
                                'limit',
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
                                'discipline_evaluation',
                            ],
                        ],
                    ],
                ]
            );
    }

    public function testDisciplineShowAssertJsonValue() {
        $this->seed(DisciplineLevelSeeder::class);
        $professionalTrajectories = ProfessionalTrajectory::factory(2)->create();
        $disciplines = Discipline::factory(5)
            ->hasAttached($professionalTrajectories, ['discipline_level_digital_value' => 1])
            ->hasCourses(3)
            ->create();
        $discipline = $disciplines->first()
            ->load(['courses', 'courses.partner', 'courses.realization']);
        $course = $discipline->courses()->first()->load('partner');
        $partner = $course->partner;
        $professionalTrajectory = $discipline->professionalTrajectories()->first();
        $response = $this->get(route('disciplines.show', $discipline));
        $response->assertOk()
            ->assertJson(
                fn(AssertableJson $json) => $json->has(
                    'discipline',
                    fn(AssertableJson $json) => $json->where('id', $discipline->id)
                        ->where('title', $discipline->title)
                        ->where('description', $discipline->description)
                        ->has('courses', 3, fn(AssertableJson $json) => $json->where('id', $course->id)
                            ->where('title', $course->title)
                            ->where('description', $course->description)
                            ->where('limit', $course->limit)
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
                                    'discipline_evaluation',
                                    $professionalTrajectory->pivot->discipline_level_digital_value
                                )
                                ->where('icons', [])
                                ->etc()
                        )
                )
            );
    }

    public function testDisciplineNonExistingShow() {
        $discipline = Discipline::factory(5)
                ->create()
                ->last()
                ->id + 100;

        $this->get(route('disciplines.show', $discipline))
            ->assertStatus(404);
    }
}
