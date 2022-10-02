<?php

namespace Database\Seeders;

use App\Models\Semester;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SemesterSeeder extends Seeder
{

    private array $semesters = [
        ['Первый семестр', '1'],
        ['Второй семестр', '2'],
        ['Третий семестр', '3'],
        ['Четвертый семестр', '4'],
        ['Пятый семестр', '5'],
        ['Шестой семестр', '6'],
        ['Седьмой семестр', '7'],
        ['Восьмой семестр', '8'],
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        collect($this->semesters)->each(function ( $semester ) {
            Semester::create([
                    'text_representation'      => $semester[0],
                    'numerical_representation' => $semester[1],
                ]
            );
        });
    }
}
