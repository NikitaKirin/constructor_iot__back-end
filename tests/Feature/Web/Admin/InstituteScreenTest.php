<?php

namespace Tests\Feature\Web\Admin;

use App\Models\User;
use Database\Seeders\AdmissionCommitteeContactsBlockSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Orchid\Support\Facades\Dashboard;
use Orchid\Support\Testing\ScreenTesting;
use Tests\TestCase;

class InstituteScreenTest extends TestCase
{
    use ScreenTesting, RefreshDatabase;

    protected function setUp(): void {
        parent::setUp();
        $this->seed(AdmissionCommitteeContactsBlockSeeder::class);
    }

    public function testGetInstituteListScreen(): void {
        $user = User::factory()->create([
            'permissions' => Dashboard::getAllowAllPermission(),
        ]);
        $response = $this->actingAs($user)->get(route('platform.institutes'));
        $response->assertStatus(200);
    }

}
