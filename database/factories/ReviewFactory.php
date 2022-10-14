<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Review>
 */
class ReviewFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition() {
        return [
            'author'                => fake()->name(),
            'text'                  => fake()->realText(),
            'educational_direction' => 'Программная инженерия',
            'year_of_issue'         => fake()->year(),
            'course'                => fake()->numberBetween(1, 5),
            'hidden'                => fake()->boolean(),
        ];
    }
}
