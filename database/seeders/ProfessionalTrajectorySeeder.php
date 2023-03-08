<?php

namespace Database\Seeders;

use App\Models\ProfessionalTrajectory;
use Illuminate\Database\Seeder;

class ProfessionalTrajectorySeeder extends Seeder
{
    private array $professionalTrajectories = [
        [
            'title'            => 'Data-science',
            'description'      => 'Описания нет',
            'color'            => '#3547F4',
            'abbreviated_name' => 'data',
        ],
        [
            'title'            => 'Web-разработка',
            'description'      => 'Описания нет',
            'color'            => '#3689F5',
            'abbreviated_name' => 'web',
        ],
        [
            'title'            => 'Администрирование баз данных',
            'description'      => 'Описания нет',
            'color'            => '#FA541C',
            'abbreviated_name' => 'database',
        ],
        [
            'title'            => 'Mobile разработка',
            'description'      => 'Описания нет',
            'color'            => '#36C8F5',
            'abbreviated_name' => 'mobile',
        ],
        [
            'title'            => 'GameDev',
            'description'      => 'Описания нет',
            'color'            => '#6236F5',
            'abbreviated_name' => 'gamedev',
        ],
        [
            'title'            => 'Desktop разработка',
            'description'      => 'Описания нет',
            'color'            => '#36F5E2',
            'abbreviated_name' => 'desktop',
        ],
        [
            'title'            => 'Управление проектами',
            'description'      => 'Описания нет',
            'color'            => '#A8F536',
            'abbreviated_name' => 'projects',
        ],
        [
            'title'            => 'Аналитика',
            'description'      => 'Описания нет',
            'color'            => '#36F562',
            'abbreviated_name' => 'analytics',
        ],
        [
            'title'            => 'DevOps',
            'description'      => 'Описания нет',
            'color'            => '#FA8C16',
            'abbreviated_name' => 'devops',
        ],
        [
            'title'            => 'Интернет-маркетинг',
            'description'      => 'Описания нет',
            'color'            => '#36F5A2',
            'abbreviated_name' => 'marketing',
        ],
        [
            'title'            => 'Программирование 1с, ERP',
            'description'      => 'Описания нет',
            'color'            => '#E236F5',
            'abbreviated_name' => '1c',
        ],
        [
            'title'            => 'Информационная безопасность',
            'description'      => 'Описания нет',
            'color'            => '#73D13D',
            'abbreviated_name' => 'security',
        ],
        [
            'title'            => 'Робототехника',
            'description'      => 'Описания нет',
            'color'            => '#F53689',
            'abbreviated_name' => 'robots',
        ],
        [
            'title'            => 'Дизайн',
            'description'      => 'Описания нет',
            'color'            => '#E8F536',
            'abbreviated_name' => 'ux/ui',
        ],
        [
            'title'            => 'Тестирование',
            'description'      => 'Описания нет',
            'color'            => '#A236F5',
            'abbreviated_name' => 'tests',
        ],
        [
            'title'            => 'IOT',
            'description'      => 'Описания нет',
            'color'            => '#F53649',
            'abbreviated_name' => 'iot',
        ],
    ];

    public function run() {
        collect($this->professionalTrajectories)
            ->each(function ($professionalTrajectory) {
                ProfessionalTrajectory::create($professionalTrajectory);
            });
    }
}
