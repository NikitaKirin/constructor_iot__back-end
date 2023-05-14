<?php

namespace Tests\Feature\Api\v1;

use App\Models\Semester;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class SemesterTest extends TestCase
{
    use RefreshDatabase;

    public function testSemestersIndexAssertJsonStructure() {
        Semester::factory()->create();
        $this->get(route('semesters.index'))->assertOk()
            ->assertJsonStructure([
                'semesters' => [
                    '*' => [
                        'id',
                        'text_representation',
                        'numerical_representation',
                    ],
                ],
            ]);
    }

    public function testSemestersIndexAssertJsonValue() {
        $semester = Semester::factory()->create()->first();
        $this->get(route('semesters.index'))->assertOk()
            ->assertJson(fn(AssertableJson $json) => $json->has(
                'semesters.0',
                fn(AssertableJson $json) => $json->where('id', $semester->id)
                    ->where('text_representation', $semester->text_representation)
                    ->where('numerical_representation', $semester->numerical_representation)
            )->etc()
            );
    }
}
