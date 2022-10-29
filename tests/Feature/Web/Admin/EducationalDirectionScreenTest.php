<?php

namespace Tests\Feature\Web\Admin;

use App\Models\User;
use Database\Seeders\AdmissionCommitteeContactsBlockSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Orchid\Support\Facades\Dashboard;
use Tests\TestCase;

class EducationalDirectionScreenTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void {
        parent::setUp();
        $this->seed(AdmissionCommitteeContactsBlockSeeder::class);
    }

    public function testGetEducationalDirectionListScreen(): void {
        $user = User::factory()->create([
            'permissions' => Dashboard::getAllowAllPermission(),
        ]);
        $response = $this->actingAs($user)->get(route('platform.educationalDirections'));
        $response->assertStatus(200);
    }
}
