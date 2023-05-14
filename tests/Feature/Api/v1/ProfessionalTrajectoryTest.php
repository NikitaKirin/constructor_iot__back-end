<?php

namespace Tests\Feature\Api\v1;

use App\Models\CourseAssembly;
use App\Models\Profession;
use App\Models\ProfessionalTrajectory;
use Database\Seeders\CourseAssemblyLevelSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class ProfessionalTrajectoryTest extends TestCase
{
    use RefreshDatabase;

    public function testProfessionalTrajectoryIndexAssertJsonStructure() {
        ProfessionalTrajectory::factory(5)->create();
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

    public function testProfessionalTrajectoryIndexWithProfessionsAssertJsonStructure() {
        ProfessionalTrajectory::factory(5)->hasProfessions()->create();
        $response = $this->get(route('professionalTrajectories.index', ['loadProfessions' => true]));
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
                    'amount_vacancies',
                    'professions' => [
                        '*' => [
                            'id',
                            'title',
                            'description',
                            'vacancies_count',
                            'minimal_salary',
                            'maximal_salary',
                            'median_salary',
                            'photo',
                        ],
                    ],
                ],
            ],
        ]);
    }

    public function testProfessionalTrajectoryIndexAssertJsonValue() {
        $professionalTrajectory = ProfessionalTrajectory::factory()->create()->first();
        $response = $this->get(route('professionalTrajectories.index'));
        $response->assertOk();
        $response->assertJson(fn(AssertableJson $json) => $json->has('professional_trajectories.0',
            fn(AssertableJson $json) => $json->where('id', $professionalTrajectory->id)
                ->where('title', $professionalTrajectory->title)
                ->where('description', $professionalTrajectory->description)
                ->where('abbreviated_name', $professionalTrajectory->abbreviated_name)
                ->where('color', $professionalTrajectory->color)
                ->where('icons', [])
                ->etc()
        ));
    }

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

    public function testProfessionalTrajectoryExistingShowWithCourseAssembliesCountAssertJsonValue() {
        $this->seed(CourseAssemblyLevelSeeder::class);
        $professionalTrajectory = ProfessionalTrajectory::factory(5)->hasAttached(
            CourseAssembly::factory(),
            ['course_assembly_level_digital_value' => 1]
        )->create()->first()->loadCount('courseAssemblies');
        $this->get(route(
                'professionalTrajectories.show',
                [$professionalTrajectory, '?loadCourseAssembliesCount=true']
            )
        )->assertOk()
            ->assertJson(
                fn(AssertableJson $json) => $json->has('professional_trajectory', fn(AssertableJson $json) => $json
                    ->where('id', $professionalTrajectory->id)
                    ->where('title', $professionalTrajectory->title)
                    ->where('description', $professionalTrajectory->description)
                    ->where('abbreviated_name', $professionalTrajectory->abbreviated_name)
                    ->where('color', $professionalTrajectory->color)
                    ->where('icons', [])
                    ->where('course_assemblies_count', $professionalTrajectory->course_assemblies_count)
                    ->etc()
                )
            );
    }

    public function testProfessionalTrajectoryShowWithProfessionsAssertJsonValue() {
        $profession = Profession::factory()->hasProfessionalTrajectories()->create()->first();
        $professionalTrajectory = ProfessionalTrajectory::first();
        $response = $this->get(route('professionalTrajectories.show', [$professionalTrajectory, '?loadProfessions=true']))
            ->assertOk()
            ->assertJson(
                fn(AssertableJson $json) => $json->has('professional_trajectory', fn(AssertableJson $json) => $json
                    ->where('id', $professionalTrajectory->id)
                    ->where('title', $professionalTrajectory->title)
                    ->where('description', $professionalTrajectory->description)
                    ->where('abbreviated_name', $professionalTrajectory->abbreviated_name)
                    ->where('color', $professionalTrajectory->color)
                    ->where('icons', [])
                    ->has(
                        'professions.0',
                        fn(AssertableJson $json) => $json->where('id', $profession->id)
                            ->where('title', $profession->title)
                            ->where('description', $profession->description)
                            ->where('vacancies_count', $profession->vacancies_count)
                            ->where('area_vacancies_count', $profession->area_vacancies_count)
                            ->where('maximal_salary', $profession->maximal_salary)
                            ->where('minimal_salary', $profession->minimal_salary)
                            ->where('median_salary', $profession->median_salary)
                            ->etc()
                    )
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
