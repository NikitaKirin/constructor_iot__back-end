<?php

namespace Database\Seeders;

use App\Models\Institute;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InstituteSeeder extends Seeder
{
    private array $institutes = [
        [
            'title'        => 'Институт радиоэлектроники и информационных технологий-РТФ',
            'abbreviation' => 'ИРИТ-РТФ',
        ],
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        collect($this->institutes)->each(function ( $institute ) {
            Institute::create([
                'title'        => $institute['title'],
                'abbreviation' => $institute['abbreviation'],
            ]);
        });
    }
}
