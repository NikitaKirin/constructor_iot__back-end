<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Orchid\Platform\Dashboard;
use Orchid\Platform\ItemPermission;

class PermissionServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register() {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(Dashboard $dashboard) {
        $permissions = ItemPermission::group(__('Сущности системы'))
            ->addPermission('institutes', __('Институты'))
            ->addPermission('educationalPrograms', __('Образовательные программы'))
            ->addPermission('professionalTrajectories', __('Профессиональные траектории'))
            ->addPermission('professions', __('Профессии'))
            ->addPermission('disciplines', __('Дисциплины'))
            ->addPermission('courseAssemblies', __('Курсовые сборки'))
            ->addPermission('courses', __('Курсы'))
            ->addPermission('employees', __('Сотрудники'))
            ->addPermission('partners', __('Партнеры'))
            ->addPermission('reviews', __('Отзывы'))
            ->addPermission('faq', __('FAQ'))
            ->addPermission('contacts', __('Контакты отборочной комиссии'));

        $dashboard->registerPermissions($permissions);
        $dashboard->registerPermissions(ItemPermission::group('Система')
            ->addPermission('logs', __('Логи системы')));
    }
}
