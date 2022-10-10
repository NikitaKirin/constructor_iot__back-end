<?php

namespace Tests\Feature\Web\Admin;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Orchid\Support\Facades\Dashboard;
use Orchid\Support\Testing\ScreenTesting;
use Tests\TestCase;

class InstituteScreenTest extends TestCase
{
    use ScreenTesting, RefreshDatabase;


    public function testGetInstituteListScreen(): void {
        $user = User::factory()->create([
            'permissions' => Dashboard::getAllowAllPermission(),
        ]);
        $response = $this->actingAs($user)->get(route('platform.institutes'));
        $response->assertStatus(200);
    }

}
