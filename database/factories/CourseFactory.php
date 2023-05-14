<?php

namespace Database\Factories;

use App\Models\CourseAssembly;
use App\Models\Partner;
use App\Models\Realization;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Course>
 */
class CourseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'title' => $this->faker->unique()->name,
            'description' => $this->faker->realText,
            'partner_id' => Partner::factory(),
            'user_id' => User::factory(),
            'realization_id' => Realization::factory(),
        ];
    }
}
