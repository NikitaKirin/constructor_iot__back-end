<?php

namespace Database\Seeders;

use App\Models\EducationalProgram;
use App\Models\Institute;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EducationalProgramSeeder extends Seeder
{
    private array $educationalPrograms = [
        [
            'title'                => 'Программная инженерия',
            'educationalDirection' => '09.03.04 Программная инженерия',
        ],
        [
            'title'                => 'Прикладная информатика',
            'educationalDirection' => '09.03.04 Прикладная информатика',
        ],
        [
            'title'                => 'Информатика и вычислительная техника',
            'educationalDirection' => '09.03.01 Информатика и вычислительная техника',
        ],
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $rtf = Institute::where('abbreviation', 'ILIKE', 'ИРИТ-РТФ')->get()->first();
        collect($this->educationalPrograms)->each(function ($educationalProgram) use ($rtf) {
            $rtf->educationalPrograms()->create(
                [
                    'title'                 => $educationalProgram['title'],
                    'educational_direction' => $educationalProgram['educationalDirection'],
                    'training_period' => '4 года',
                    'budget_places' => 100,
                ]
            )->save();
        });
    }
}
