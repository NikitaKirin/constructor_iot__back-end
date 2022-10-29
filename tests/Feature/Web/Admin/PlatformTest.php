<?php


namespace Tests\Feature\Web\Admin;

use App\Models\User;
use Database\Seeders\AdmissionCommitteeContactsBlockSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Orchid\Support\Facades\Dashboard;
use Orchid\Support\Testing\ScreenTesting;
use Tests\TestCase;

class PlatformTest extends TestCase
{
    use ScreenTesting, RefreshDatabase;

    protected function setUp(): void {
        parent::setUp();
        $this->seed(AdmissionCommitteeContactsBlockSeeder::class);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testPlatformAccessStatusWithoutPermissions(): void {

        $user = User::factory()
                    ->create();

        $status = $this->actingAs($user)->get(route('platform.main'));

        $status->assertForbidden();
    }

    public function testPlatformAccessWithPermission() {
        $user = User::factory()
                    ->create([
                        'permissions' => Dashboard::getAllowAllPermission(),
                    ]);
        $status = $this->actingAs($user)->get(route('platform.main'));
        $status->assertOk();
    }
}
