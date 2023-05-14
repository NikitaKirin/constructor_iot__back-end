<?php

namespace Tests\Feature\Api\v1;

use App\Models\Review;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class ReviewTest extends TestCase
{
    use RefreshDatabase;

    public function testReviewsIndexAssertJsonStructure() {
        Review::factory()->create();
        $response = $this->get(route('reviews.index'));
        $response->assertOk();
        $response->assertJsonStructure([
            'reviews' => [
                '*' => [
                    'id',
                    'author',
                    'text',
                    'educational_direction',
                    'course',
                    'year_of_issue',
                    'photo',
                ]
            ]
        ]);
    }
    public function testReviewsIndexAssertJsonValue()
    {
        $testReview = Review::factory(10)->create()->first();

        $response = $this->get(route('reviews.index'));

        $response->assertOk();

        $response->assertJson(fn(AssertableJson $json) => $json->has('meta')
            ->has('links', 4)
            ->has('reviews', 2)
            ->has(
                'reviews.0',
                fn($json) => $json->where('id', $testReview->id)
                    ->where(
                        'author',
                        $testReview->author
                    )
                    ->where(
                        'text',
                        $testReview->text
                    )
                    ->where(
                        'educational_direction',
                        $testReview->educational_direction
                    )
                    ->where(
                        'year_of_issue',
                        $testReview->year_of_issue
                    )
                    ->where(
                        'course',
                        $testReview->course
                    )
                    ->etc()
            )
        );
    }
}
