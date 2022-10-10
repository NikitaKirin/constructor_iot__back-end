<?php

namespace Tests\Feature\Api\v1;

use App\Models\Review;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class ReviewTest extends TestCase
{
    use RefreshDatabase;

    public function testReviewIndex() {

        $testReview = Review::factory(10)->create()->first();

        $response = $this->get(route('reviews.index'));

        $response->assertOk();

        $response->assertJson(fn( AssertableJson $json ) => $json->has('meta')
                                                                 ->has('links', 4)
                                                                 ->has('reviews', 5)
                                                                 ->has('reviews.0',
                                                                     fn( $json ) => $json->where('id', $testReview->id)
                                                                                         ->where('author',
                                                                                             $testReview->author)
                                                                                         ->where('text',
                                                                                             $testReview->text)
                                                                                         ->where('additional_information',
                                                                                             $testReview->additional_information)
                                                                                         ->etc()
                                                                 )
        );
    }
}
