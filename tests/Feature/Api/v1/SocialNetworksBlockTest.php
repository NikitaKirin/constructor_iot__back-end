<?php

namespace Tests\Feature\Api\v1;

use App\Models\SocialNetworksBlock;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class SocialNetworksBlockTest extends TestCase
{
    use RefreshDatabase;

    public function testSocialNetworksBlockIndex()
    {
        SocialNetworksBlock::factory()
            ->count(1)
            ->create();

        $response = $this->get(route('socialNetworksBlocks.index'));
        $response->assertOk();

        $response->assertJson(fn(AssertableJson $json) => $json->has('social_networks_block')
            ->etc()
        );
    }
}
