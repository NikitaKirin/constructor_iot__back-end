<?php

namespace Database\Factories;

use App\Models\Discipline;
use App\Models\Semester;
use Database\Seeders\SemesterSeeder;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\EducationalModule>
 */
class EducationalModuleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'title' => fake()->unique()->name,
            'choice_limit' => fake()->numberBetween(0, 10),
            'is_spec' => fake()->boolean,
            //'disciplines' => Discipline::factory(3),
        ];
    }
}
