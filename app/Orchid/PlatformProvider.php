<?php

declare(strict_types=1);

namespace App\Orchid;

use App\Models\AdmissionCommitteeContactsBlock;
use App\Models\SocialNetworksBlock;
use Orchid\Platform\Dashboard;
use Orchid\Platform\ItemPermission;
use Orchid\Platform\OrchidServiceProvider;
use Orchid\Screen\Actions\Menu;

class PlatformProvider extends OrchidServiceProvider
{
    /**
     * @param Dashboard $dashboard
     */
    public function boot(Dashboard $dashboard): void {
        parent::boot($dashboard);

        // ...
    }

    /**
     * @return Menu[]
     */
    public function registerMainMenu(): array {
        return [

            Menu::make(__('Главная страница'))
                ->icon('computer')
                ->list([
                    Menu::make(__("Контакты"))
                        ->route('platform.admissionCommitteeContactsBlocks.edit', [
                            'admissionCommitteeContactsBlock' =>
                                AdmissionCommitteeContactsBlock::first(),
                        ]),
                    Menu::make(__("Соц. сети"))
                        ->route('platform.socialNetworksBlocks.edit', [
                            'socialNetworksBlock' =>
                                SocialNetworksBlock::first(),
                        ]),
                ])->permission('contacts'),

            Menu::make(__('Институты'))
                ->icon('building')
                ->list([
                    Menu::make(__('Список институтов'))
                        ->icon('list')
                        ->route('platform.institutes'),
                    Menu::make(__('Добавить новый'))
                        ->icon('plus')
                        ->route('platform.institutes.create'),
                ])->permission('institutes'),


            Menu::make(__('Образовательные программы'))
                ->icon('graduation')
                ->list([
                    Menu::make(__('Список всех программ'))
                        ->icon('list')
                        ->route('platform.educationalPrograms'),
                ])->permission('educationalModules'),

            Menu::make(__('Профессиональные траектории'))
                ->icon('cursor')
                ->list([
                    Menu::make(__("Список профессиональных траекторий"))
                        ->icon('list')
                        ->route('platform.professionalTrajectories'),
                    Menu::make(__('Добавить новую'))
                        ->icon('plus')
                        ->route('platform.professionalTrajectories.create'),
                ])->permission('professionalTrajectories'),

            Menu::make(__('Профессии'))
                ->icon('paypal')
                ->list([
                    Menu::make(__("Список профессий"))
                        ->icon('list')
                        ->route('platform.professions'),
                    Menu::make(__('Добавить новую'))
                        ->icon('plus')
                        ->route('platform.professions.create'),
                ])->permission('professions'),

            Menu::make(__('Образовательны модули'))
                ->icon('graduation')
                ->list([
                    Menu::make(__('Список всех модулей'))
                        ->icon('list')
                        ->route('platform.educationalModules'),
                    Menu::make(__('Добавить новый'))
                        ->icon('plus')
                        ->route('platform.educationalModules.create'),
                ])->permission('educationalModules'),

            Menu::make(__('Дисциплины'))
                ->icon('graduation')
                ->list([
                    Menu::make(__('Список всех дисциплин'))
                        ->icon('list')
                        ->route('platform.disciplines'),
                    Menu::make(__('Добавить новую'))
                        ->icon('plus')
                        ->route('platform.disciplines.create'),
                ])->permission('disciplines'),

            Menu::make(__('Курсы'))
                ->icon('graduation')
                ->list([
                    Menu::make(__('Список всех курсов'))
                        ->icon('list')
                        ->route('platform.courses'),
                    Menu::make(__('Добавить новый'))
                        ->icon('plus')
                        ->route('platform.courses.create'),
                ])->permission('courses'),

            Menu::make(__('Сотрудники'))
                ->icon('people')
                ->list([
                    Menu::make(__('Список всех сотрудников'))
                        ->icon('list')
                        ->route('platform.employees'),
                    Menu::make(__('Добавить нового'))
                        ->icon('plus')
                        ->route('platform.employees.create'),
                ])->permission('employees'),

            Menu::make(__('Партнеры'))
                ->icon('briefcase')
                ->list([
                    Menu::make(__('Список всех партнеров'))
                        ->icon('list')
                        ->route('platform.partners'),
                    Menu::make(__('Добавить нового'))
                        ->icon('plus')
                        ->route('platform.partners.create'),
                ])->permission('partners'),

            Menu::make(__('Отзывы'))
                ->icon('briefcase')
                ->list([
                    Menu::make(__('Список всех отзывов'))
                        ->icon('list')
                        ->route('platform.reviews'),
                    Menu::make(__('Добавить новый'))
                        ->icon('plus')
                        ->route('platform.reviews.create'),
                ])
                ->icon('like')
                ->permission('review'),

            Menu::make(__('FAQ'))
                ->icon('question')
                ->list([
                    Menu::make(__('Список всех вопросов'))
                        ->icon('list')
                        ->route('platform.faq'),
                    Menu::make(__('Добавить новый'))
                        ->icon('plus')
                        ->route('platform.faq.create'),
                ])->permission('faq')
                ->divider(),

            Menu::make(__('Панель разработчика'))
                ->route('telescope.index')
                ->icon('monitor')
                ->title(__('Разработчикам'))
                ->permission('logs'),


            /*Menu::make('Example screen')
                ->icon('monitor')
                ->route('platform.example')
                ->title('Navigation')
                ->badge(function () {
                    return 6;
                }),

            Menu::make('Dropdown menu')
                ->icon('code')
                ->list([
                    Menu::make('Sub element item 1')->icon('bag'),
                    Menu::make('Sub element item 2')->icon('heart'),
                ]),

            Menu::make('Basic Elements')
                ->title('Form controls')
                ->icon('note')
                ->route('platform.example.fields'),

            Menu::make('Advanced Elements')
                ->icon('briefcase')
                ->route('platform.example.advanced'),

            Menu::make('Text Editors')
                ->icon('list')
                ->route('platform.example.editors'),

            Menu::make('Overview layouts')
                ->title('Layouts')
                ->icon('layers')
                ->route('platform.example.layouts'),

            Menu::make('Chart tools')
                ->icon('bar-chart')
                ->route('platform.example.charts'),

            Menu::make('Cards')
                ->icon('grid')
                ->route('platform.example.cards')
                ->divider(),

            Menu::make('Documentation')
                ->title('Docs')
                ->icon('docs')
                ->url('https://orchid.software/en/docs'),

            Menu::make('Changelog')
                ->icon('shuffle')
                ->url('https://github.com/orchidsoftware/platform/blob/master/CHANGELOG.md')
                ->target('_blank')
                ->badge(function () {
                    return Dashboard::version();
                }, Color::DARK()),*/

            Menu::make(__('Users'))
                ->icon('user')
                ->route('platform.systems.users')
                ->permission('platform.systems.users')
                ->title(__('Access rights')),

            Menu::make(__('Roles'))
                ->icon('lock')
                ->route('platform.systems.roles')
                ->permission('platform.systems.roles'),

        ];
    }

    /**
     * @return Menu[]
     */
    public function registerProfileMenu(): array {
        return [
            Menu::make('Profile')
                ->route('platform.profile')
                ->icon('user'),
        ];
    }

    /**
     * @return ItemPermission[]
     */
    public function registerPermissions(): array {
        return [
            ItemPermission::group(__('System'))
                ->addPermission('platform.systems.roles', __('Roles'))
                ->addPermission('platform.systems.users', __('Users')),
        ];
    }
}
