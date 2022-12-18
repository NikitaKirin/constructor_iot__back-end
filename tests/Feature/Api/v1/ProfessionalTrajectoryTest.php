<?php

namespace Tests\Feature\Api\v1;

use App\Models\ProfessionalTrajectory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class ProfessionalTrajectoryTest extends TestCase
{
    use RefreshDatabase;

    public function testProfessionalTrajectoryIndexAssertJsonStructure()
    {
        ProfessionalTrajectory::factory(5)
            ->create();
        $response = $this->get(route('professionalTrajectories.index'));
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'professional_trajectories' => [
                '*' => [
                    'id',
                    'title',
                    'description',
                    'slug',
                    'color',
                    'sum_discipline_levels_points',
                    'icons',
                    'vacancies_count',
                ],
            ],
        ]);
    }

    public function testProfessionalTrajectoryIndexAssertJsonValue()
    {
        $professionalTrajectories = ProfessionalTrajectory::factory(5)
            ->create();
        $professionalTrajectory = $professionalTrajectories->first();
        $response = $this->get(route('professionalTrajectories.index'));
        $response->assertOk();
        $response->assertJson(fn(AssertableJson $json) => $json->has('professional_trajectories', 5)
            ->has(
                'professional_trajectories.0',
                fn(AssertableJson $json) => $json->where('id', $professionalTrajectory->id)
                    ->where('title', $professionalTrajectory->title)
                    ->where('description', $professionalTrajectory->description)
                    ->where('slug', $professionalTrajectory->slug)
                    ->where('color', $professionalTrajectory->color)
                    ->where('sum_discipline_levels_points', $professionalTrajectory->sum_discipline_levels_points)
                    ->where('icons', [])
                    ->etc()
            ));
    }
}