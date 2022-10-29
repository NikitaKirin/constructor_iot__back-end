<?php

namespace Tests\Feature\Web\Admin;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Orchid\Support\Facades\Dashboard;
use Tests\TestCase;

class EducationalDirectionScreenTest extends TestCase
{
    use RefreshDatabase;

    public function testGetEducationalDirectionListScreen(): void {
        $user = User::factory()->create([
            'permissions' => Dashboard::getAllowAllPermission(),
        ]);
        $response = $this->actingAs($user)->get(route('platform.educationalDirections'));
        $response->assertStatus(200);
    }
}
