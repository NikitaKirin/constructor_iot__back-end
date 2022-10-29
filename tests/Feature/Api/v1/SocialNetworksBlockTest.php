<?php

namespace Tests\Feature\Api\v1;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SocialNetworksBlockTest extends TestCase
{
    use RefreshDatabase;

    public function testSocialNetworksBlockIndex() {
        $response = $this->get(route('socialNetworksBlocks.index'));
        $response->assertStatus(200);
    }
}
