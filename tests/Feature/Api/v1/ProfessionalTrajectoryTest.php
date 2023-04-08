<?php

namespace Tests\Feature\Api\v1;

use App\Models\ProfessionalTrajectory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class ProfessionalTrajectoryTest extends TestCase
{
    use RefreshDatabase;

    public function testProfessionalTrajectoryIndexAssertJsonStructure() {
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
                    'abbreviated_name',
                    'color',
                    'icons',
                ],
            ],
        ]);
    }

/*    public function testProfessionalTrajectoryIndexAssertJsonValue() {
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
                    ->where('abbreviated_name', $professionalTrajectory->abbreviated_name)
                    ->where('color', $professionalTrajectory->color)
                    ->where('icons', [])
                    ->etc()
            ));
    }*/

    public function testProfessionalTrajectoryExistingShowWithoutCourseAssembliesCount() {
        $professionalTrajectories = ProfessionalTrajectory::factory(5)
            ->create();
        $professionalTrajectory = $professionalTrajectories->first();
        $response = $this->get(route('professionalTrajectories.show', $professionalTrajectory))
            ->assertOk()
            ->assertJson(
                fn(AssertableJson $json) => $json->has('professional_trajectory', fn(AssertableJson $json) => $json
                    ->where('id', $professionalTrajectory->id)
                    ->where('title', $professionalTrajectory->title)
                    ->where('description', $professionalTrajectory->description)
                    ->where('abbreviated_name', $professionalTrajectory->abbreviated_name)
                    ->where('color', $professionalTrajectory->color)
                    ->where('icons', [])
                    ->etc()
                )
            );
    }

    public function testProfessionalTrajectoryExistingShowWithCourseAssembliesCount() {
        $professionalTrajectories = ProfessionalTrajectory::factory(5)
            ->create();
        $professionalTrajectory = $professionalTrajectories->first()->loadCount('courseAssemblies');
        $response = $this->get(
            route('professionalTrajectories.show', [$professionalTrajectory, '?courseAssembliesCount=true'])
        )
            ->assertOk()
            ->assertJson(
                fn(AssertableJson $json) => $json->has('professional_trajectory', fn(AssertableJson $json) => $json
                    ->where('id', $professionalTrajectory->id)
                    ->where('title', $professionalTrajectory->title)
                    ->where('description', $professionalTrajectory->description)
                    ->where('abbreviated_name', $professionalTrajectory->abbreviated_name)
                    ->where('color', $professionalTrajectory->color)
                    ->where('icons', [])
                    ->etc()
                )
            );
    }

    public function testProfessionalTrajectoryNonExistingShow() {
        $id = ProfessionalTrajectory::all()->last()?->id + 100;

        $response = $this->get(route('professionalTrajectories.show', $id))
            ->assertStatus(404);
    }
}
