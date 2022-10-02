<?php

namespace Database\Seeders;

use App\Models\Position;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PositionsSeeder extends Seeder
{
    private array $positionTitles = [
        'Руководитель образовательной программы',
        'Тьютор',
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        collect($this->positionTitles)->each(function ( $positionTitle ) {
            Position::create(['title' => $positionTitle]);
        });
    }
}
