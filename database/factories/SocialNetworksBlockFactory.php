<?php

namespace Database\Factories;

use App\Models\Institute;
use App\Models\SocialNetworksBlock;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class SocialNetworksBlockFactory extends Factory
{
    protected $model = SocialNetworksBlock::class;

    public function definition(): array
    {
        return [
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'institute_id' => Institute::factory(),
            'user_id' => User::factory(),
        ];
    }
}
