<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Employee;
use App\Models\Institute;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run() {
        DB::transaction(function () {
            $this->call([
                InstituteSeeder::class,
                EducationalDirectionSeeder::class,
                PositionsSeeder::class,
                SemesterSeeder::class,
                EmployeeSeeder::class,
            ]);
        });
    }
}
