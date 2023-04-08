<?php

namespace Database\Seeders;

use App\Models\CourseAssembly;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CourseAssemblySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        CourseAssembly::factory(10)->create();
    }
}
