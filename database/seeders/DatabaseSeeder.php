<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
                EducationalProgramSeeder::class,
                PositionSeeder::class,
                SemesterSeeder::class,
                RealizationSeeder::class,
                AdmissionCommitteeContactsBlockSeeder::class,
                SocialNetworksBlockSeeder::class,
                CourseAssemblyLevelSeeder::class,
            ]);
        });
    }
}
