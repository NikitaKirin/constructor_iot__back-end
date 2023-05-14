<?php

namespace Tests\Feature\Api\v1;

use App\Models\EducationalProgram;
use Database\Seeders\EducationalProgramSeeder;
use Database\Seeders\InstituteSeeder;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class EducationalProgramTest extends TestCase
{
    use RefreshDatabase;

    public function testEducationalProgramsIndexAssertJsonStructure()
    {
        EducationalProgram::factory(3)->create();
        $response = $this->get(route('educationalPrograms.index'));
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'educational_programs' => [
                '*' => [
                    'id',
                    'title',
                    'educational_direction',
                    'passing_scores' => [
                        '*' => [
                            'year',
                            'passing_score',
                        ],
                    ],
                    'training_period',
                    'budget_places',
                    'page_link',
                ],
            ],
        ]);
    }

    public function testEducationalProgramsIndexAssertJsonData()
    {
        EducationalProgram::factory(3)
            ->hasDisciplines(2)
            ->create();
        $educationalProgram = EducationalProgram::orderBy('title')->first();
        $response = $this->get(route('educationalPrograms.index'));
        $response->assertOk();
        $response->assertJson(fn(AssertableJson $json) => $json->has(
                'educational_programs.0',
                fn(AssertableJson $json) => $json->where('id', $educationalProgram->id)
                    ->where('title', $educationalProgram->title)
                    ->where('educational_direction', $educationalProgram->educational_direction)
                    ->where('passing_scores', $educationalProgram->passing_scores)
                    ->where('training_period', $educationalProgram->training_period)
                    ->where('budget_places', $educationalProgram->budget_places)
                    ->where('page_link', $educationalProgram->page_link)
            )
            ->etc());
    }
}
