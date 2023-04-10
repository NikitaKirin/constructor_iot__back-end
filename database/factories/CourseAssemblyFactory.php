<?php

namespace Database\Factories;

use App\Models\Discipline;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CourseAssembly>
 */
class CourseAssemblyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition() {
        return [
            'title'       => fake()->title(),
            'description' => fake()->realText(),
            'discipline_id' => Discipline::factory(1)->create()->id,
        ];
    }
}
