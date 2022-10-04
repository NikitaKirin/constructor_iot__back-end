<?php

namespace Database\Seeders;

use App\Models\EducationalDirection;
use App\Models\Institute;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EducationalDirectionSeeder extends Seeder
{
    private array $educationalDirections = [
        [
            'title'  => 'Программная инженерия',
            'cipher' => '09.03.04',
        ],
        [
            'title'  => 'Прикладная информатика',
            'cipher' => '09.03.03',
        ],
        [
            'title'  => 'Информатика и вычислительная техника',
            'cipher' => '09.03.01',
        ],
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $rtf = Institute::where('abbreviation', 'ILIKE', 'ИРИТ-РТФ')->get()->first();
        collect($this->educationalDirections)->each(function ( $educationalDirection ) use ( $rtf ) {
            $rtf->educationalDirections()->create(
                [
                    'title'  => $educationalDirection['title'],
                    'cipher' => $educationalDirection['cipher'],
                ]
            )->save();
        });
    }
}
