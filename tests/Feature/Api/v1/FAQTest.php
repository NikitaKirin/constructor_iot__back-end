<?php

namespace Tests\Feature\Api\v1;

use App\Models\FAQ;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class FAQTest extends TestCase
{
    use RefreshDatabase;

    public function testFAQIndexAssertJsonStructure() {
        FAQ::factory()->create();
        $this->get(route('faq.index'))
            ->assertOk()
            ->assertJsonStructure([
                'FAQ' => [
                    '*' => [
                        'id',
                        'question',
                        'answer',
                    ],
                ],
            ]);
    }

    public function testFAQIndexAssertJsonData() {
        $faq = FAQ::factory()->create()->first();
        $this->get(route('faq.index'))
            ->assertOk()
            ->assertJson(fn(AssertableJson $json) => $json->has(
                'FAQ.0',
                fn(AssertableJson $json) => $json->where('id', $faq->id)
                    ->where('question', $faq->question)
                    ->where('answer', $faq->answer)
            )
            );
    }

}
