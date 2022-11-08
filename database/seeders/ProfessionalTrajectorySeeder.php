<?php

namespace Database\Seeders;

use App\Models\ProfessionalTrajectory;
use Illuminate\Database\Seeder;

class ProfessionalTrajectorySeeder extends Seeder
{
    private array $professionalTrajectories = [
        [
            'title'       => 'Data-science',
            'description' => 'Описания нет',
            'color'       => '#3547F4',
        ],
        [
            'title'       => 'Web-разработка',
            'description' => 'Описания нет',
            'color'       => '#3689F5',
        ],
        [
            'title'       => 'Администрирование баз данных',
            'description' => 'Описания нет',
            'color'       => '#FA541C',
        ],
        [
            'title'       => 'Mobile разработка',
            'description' => 'Описания нет',
            'color'       => '#36C8F5',
        ],
        [
            'title'       => 'GameDev',
            'description' => 'Описания нет',
            'color'       => '#6236F5',
        ],
        [
            'title'       => 'Desktop разработка',
            'description' => 'Описания нет',
            'color'       => '#36F5E2',
        ],
        [
            'title'       => 'Управление проектами',
            'description' => 'Описания нет',
            'color'       => '#A8F536',
        ],
        [
            'title'       => 'Аналитика',
            'description' => 'Описания нет',
            'color'       => '#36F562',
        ],
        [
            'title'       => 'DevOps',
            'description' => 'Описания нет',
            'color'       => '#FA8C16',
        ],
        [
            'title'       => 'Интернет-маркетинг',
            'description' => 'Описания нет',
            'color'       => '#36F5A2',
        ],
        [
            'title'       => 'Программирование 1с, ERP',
            'description' => 'Описания нет',
            'color'       => '#E236F5',
        ],
        [
            'title'       => 'Информационная безопасность',
            'description' => 'Описания нет',
            'color'       => '#73D13D',
        ],
        [
            'title'       => 'Робототехника',
            'description' => 'Описания нет',
            'color'       => '#F53689',
        ],
        [
            'title'       => 'Дизайн',
            'description' => 'Описания нет',
            'color'       => '#E8F536',
        ],
        [
            'title'       => 'Тестирование',
            'description' => 'Описания нет',
            'color'       => '#A236F5',
        ],
        [
            'title'       => 'IOT',
            'description' => 'Описания нет',
            'color'       => '#F53649',
        ],
    ];

    public function run() {
        collect($this->professionalTrajectories)
            ->each(function ( $professionalTrajectory ) {
                ProfessionalTrajectory::create($professionalTrajectory);
            });
    }
}
