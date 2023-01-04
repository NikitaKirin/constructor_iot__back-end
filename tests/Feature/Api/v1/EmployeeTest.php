<?php

namespace Tests\Feature\Api\v1;

use App\Http\Resources\Position\PositionResource;
use App\Models\Employee;
use Database\Factories\EmployeeFactory;
use Database\Seeders\PositionsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class EmployeeTest extends TestCase
{
    use RefreshDatabase;

    public function testEmployeeIndexAssertJsonStructure()
    {
        $this->seed([PositionsSeeder::class]);

        Employee::factory(10)->create();

        $response = $this->get(route('employees.index'));

        $response->assertOk()
            ->assertJsonStructure([
                'employees' => [
                    '*' => [
                        'id',
                        'full_name',
                        'email',
                        'phone_number',
                        'address',
                        'audience',
                        'additional_information',
                        'photo',
                        'position',
                        'vk_profile',
                    ],
                ],
            ]);
    }

    public function testEmployeeIndexAssertJsonValue()
    {
        $this->seed([PositionsSeeder::class]);

        $employee = Employee::factory(10)
            ->create()->sortBy('full_name')->first();

        $response = $this->get(route('employees.index'));

        $response->assertOk()
            ->assertJson(fn(AssertableJson $json) => $json->has('employees', 10)
                ->has('employees.0', fn(AssertableJson $json) => $json->where('id', $employee->id)
                    ->where('full_name', $employee->full_name)
                    ->where('email', $employee->email)
                    ->where('phone_number', $employee->phone_number)
                    ->where('address', $employee->address)
                    ->where('audience', $employee->audience)
                    ->where('additional_information', $employee->additional_information)
                    ->where('vk_profile', $employee->vk_profile)
                    ->where('photo', $employee->photo->url() ?? asset(config('constants.avatars.employee.url')))
                    ->has('position', fn(AssertableJson $json) => $json->where('id', $employee->position->id)
                        ->where('title', $employee->position->title))));
    }
}