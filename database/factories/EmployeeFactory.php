<?php

namespace Database\Factories;

use App\Models\Position;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Employee>
 */
class EmployeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'full_name' => fake()->name(),
            'email' => fake()->email(),
            'phone_number' => fake()->phoneNumber(),
            'address' => fake()->address(),
            'audience' => "Р".'-'.fake()->numberBetween(1, 400),
            'additional_information' => fake()->realText(100),
            'position_id' => Position::all()->random(1)->first()->id,
        ];
    }
}
