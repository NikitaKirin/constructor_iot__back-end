<?php

namespace Database\Seeders;

use App\Models\CourseAssemblyLevel;
use Illuminate\Database\Seeder;

class CourseAssemblyLevelSeeder extends Seeder
{
    private array $disciplineLevels = [
        [
            'title'         => 'Базовый',
            'digital_value' => 1,
        ],

        [
            'title'         => 'Повышенный',
            'digital_value' => 3,
        ],
    ];


    public function run() {
        collect($this->disciplineLevels)->each(fn( $disciplineLevel ) => CourseAssemblyLevel::create($disciplineLevel));
    }
}
