<?php

namespace Database\Factories;

use App\Models\Institute;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\EducationalDirection>
 */
class EducationalDirectionFactory extends Factory
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
            'cipher' => fake()->unique()->name,
            'passing_scores' => json_encode([
                [
                    'year' => null,
                    'passing_score' => null,
                ],
            ]),
            'institute_id' => Institute::factory(),
            'training_period' => '4 года',
            'page_link' => fake()->url,
        ];
    }
}
