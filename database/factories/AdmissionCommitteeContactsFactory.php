<?php

namespace Database\Factories;

use App\Models\AdmissionCommitteeContacts;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class AdmissionCommitteeContactsFactory extends Factory
{
    protected $model = AdmissionCommitteeContacts::class;

    public function definition(): array {
        return [
            'address'      => $this->faker->address(),
            'phone_number' => $this->faker->phoneNumber(),
            'email'        => $this->faker->unique()->safeEmail(),
            'created_at'   => Carbon::now(),
            'updated_at'   => Carbon::now(),
            'user_id'      => User::factory(),
        ];
    }
}
