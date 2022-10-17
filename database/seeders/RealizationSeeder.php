<?php

namespace Database\Seeders;

use App\Models\Realization;
use Illuminate\Database\Seeder;

class RealizationSeeder extends Seeder
{
    private array $realizationsData = [
        'Традиционный формат',
        'Смешанный формат',
        'Онлайн-формат',
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        collect($this->realizationsData)->each(function ( $realization ) {
            Realization::create(['title' => $realization])
                       ->save();
        });
    }
}
