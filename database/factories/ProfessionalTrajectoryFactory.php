<?php

namespace Database\Factories;

use App\Models\ProfessionalTrajectory;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class ProfessionalTrajectoryFactory extends Factory
{
    protected $model = ProfessionalTrajectory::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->unique()->word(),
            'description' => $this->faker->text(),
            'color' => $this->faker->unique()->hexColor(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'slug' => $this->faker->text(15),
            'user_id' => User::factory(),
        ];
    }
}
