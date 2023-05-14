<?php

namespace Tests\Feature\Api\v1;

use App\Models\Profession;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class HeadHunterTest extends TestCase
{
    use RefreshDatabase;

    public function testGetVacanciesInfo() {
        $profession = Profession::factory()->create()->first();
        $this->get(route('headHunter.info'))
            ->assertOk()
            ->assertJson(fn(AssertableJson $json) => $json->where('totalCount', $profession->vacancies_count)
                ->where('areaCount', $profession->area_vacancies_count)
            );
    }
}
