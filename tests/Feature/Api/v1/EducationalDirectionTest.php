<?php

namespace Tests\Feature\Api\v1;

use App\Models\EducationalDirection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class EducationalDirectionTest extends TestCase
{
    use RefreshDatabase;

    public function testEducationalDirectionsIndexAssertJsonStructure()
    {
        EducationalDirection::factory(3)->create();
        $response = $this->get(route('educationalDirections.index'));
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'educational_directions' => [
                '*' => [
                    'id',
                    'title',
                    'cipher',
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

    public function testEducationalDirectionIndexAssertJsonData()
    {
        EducationalDirection::factory(3)->create();
        $educationalDirection = EducationalDirection::orderBy('title')->first();
        $response = $this->get(route('educationalDirections.index'));
        $response->assertStatus(200);
        $response->assertJson(fn(AssertableJson $json) => $json->has('educational_directions', 3)
            ->has(
                'educational_directions.0',
                fn(AssertableJson $json) => $json->where('id', $educationalDirection->id)
                    ->where('title', $educationalDirection->title)
                    ->where('cipher', $educationalDirection->cipher)
                    ->where('passing_scores', $educationalDirection->passing_scores)
                    ->where('training_period', $educationalDirection->training_period)
                    ->where('budget_places', $educationalDirection->budget_places)
                    ->where('page_link', $educationalDirection->page_link)
            )
            ->etc());
    }
}