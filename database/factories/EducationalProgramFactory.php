<?php

namespace Database\Factories;

use App\Models\Institute;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\EducationalProgram>
 */
class EducationalProgramFactory extends Factory
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
            'educational_direction' => fake()->text(15),
            'passing_scores' => json_encode([
                [
                    'year' => null,
                    'passing_score' => null,
                ],
            ]),
            'budget_places' => 100,
            'institute_id' => Institute::factory(),
            'training_period' => '4 года',
            'page_link' => fake()->url,
        ];
    }
}
