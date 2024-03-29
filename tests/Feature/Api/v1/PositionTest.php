<?php

namespace Tests\Feature\Api\v1;

use App\Models\Position;
use Database\Seeders\PositionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class PositionTest extends TestCase
{
    use RefreshDatabase;

    public function testPositionsIndexAssertJsonStructure()
    {
        $this->seed([PositionSeeder::class]);
        $response = $this->get(route('positions.index'));

        $response->assertOk()
            ->assertJsonStructure(
                [
                    'positions' => [
                        '*' => [
                            'id',
                            'title',
                        ],
                    ],
                ]
            );
    }

    public function testPositionsIndexAssertJsonValue()
    {
        $this->seed([PositionSeeder::class]);
        $response = $this->get(route('positions.index'));
        $position = Position::all()->first();

        $response->assertOk()
            ->assertJson(fn(AssertableJson $json) => $json->has('positions')
                ->has('positions.0', fn(AssertableJson $json) => $json->where('id', $position->id)
                    ->where('title', $position->title)));
    }
}
