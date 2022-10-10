<?php

namespace Database\Seeders;

use App\Models\Partner;
use Database\Factories\PartnerFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PartnerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        Partner::factory(20)->create();
    }
}
