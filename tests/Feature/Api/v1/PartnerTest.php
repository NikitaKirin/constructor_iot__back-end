<?php

namespace Tests\Feature\Api\v1;

use App\Models\Partner;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class PartnerTest extends TestCase
{
    use RefreshDatabase;

    public function testPartnersIndex()
    {
        $testPartner = Partner::factory(10)->create()->first();

        $response = $this->get(route('partners.index'));

        $response->assertOk();

        $response->assertJson(fn(AssertableJson $json) => $json->has('meta')
            ->has('links', 4)
            ->has('partners', 5)
            ->has(
                'partners.0',
                fn($json) => $json->where('id', $testPartner->id)
                    ->where(
                        'title',
                        $testPartner->title
                    )
                    ->where(
                        'site_link',
                        $testPartner->site_link
                    )
                    ->etc()
            )
        );
    }
}
