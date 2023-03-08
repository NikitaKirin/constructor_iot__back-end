<?php

namespace Tests\Feature\Web\Admin;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Orchid\Support\Facades\Dashboard;
use Tests\TestCase;

class EducationalProgramScreenTest extends TestCase
{
    use RefreshDatabase;

    public function testGetEducationalDirectionListScreen(): void {
        $user = User::factory()->create([
            'permissions' => Dashboard::getAllowAllPermission(),
        ]);
        $response = $this->actingAs($user)->get(route('platform.educationalPrograms'));
        $response->assertStatus(200);
    }
}
