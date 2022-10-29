<?php

namespace Database\Factories;

use App\Models\AdmissionCommitteeContactsBlock;
use App\Models\Institute;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class AdmissionCommitteeContactsBlockFactory extends Factory
{
    protected $model = AdmissionCommitteeContactsBlock::class;

    public function definition(): array {
        return [
            'address'      => $this->faker->address(),
            'phone_number' => $this->faker->phoneNumber(),
            'email'        => $this->faker->unique()->safeEmail(),
            'created_at'   => Carbon::now(),
            'updated_at'   => Carbon::now(),
            'user_id'      => User::factory(),
            'institute_id' => Institute::factory()
                                       ->count(1)
                                       ->create()
                                       ->first()->id,
        ];
    }
}
