<?php

namespace Database\Factories;

use App\Models\FAQ;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class FAQFactory extends Factory
{
    protected $model = FAQ::class;

    public function definition(): array {
        return [
            'question'   => $this->faker->word(),
            'answer'     => $this->faker->word(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'deleted_at' => Carbon::now(),
            'user_id' => User::factory(),
        ];
    }
}
