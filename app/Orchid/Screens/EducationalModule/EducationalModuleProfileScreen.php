<?php

namespace App\Orchid\Screens\EducationalModule;

use App\Models\EducationalModule;
use Illuminate\Support\Facades\Config;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Screen\Sight;
use Orchid\Support\Color;
use Orchid\Support\Facades\Layout;

class EducationalModuleProfileScreen extends Screen
{
    public EducationalModule $educationalModule;

    /**
     * Query data.
     *
     * @return array
     */
    public function query( EducationalModule $educationalModule ): iterable {
        return [
            'educationalModule' => $educationalModule,
        ];
    }

    /**
     * Display header name.
     *
     * @return string|null
     */
    public function name(): ?string {
        return __("Образовательный модуль: {$this->educationalModule->title}");
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable {
        return [
            Link::make(__('Edit'))
                ->icon("pencil")
                ->route("platform.educationalModules.edit", $this->educationalModule),
            Button::make(__("Delete"))
                  ->icon('trash')
                  ->type(Color::DANGER())
                  ->confirm(__("Вы уверены, что хотите удалить партнера? Данное действие нельзя будет отменить."))
                  ->method('destroy', ['id' => $this->educationalModule->id]),
        ];
    }

    /**
     * Views.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable {
        return [
            Layout::tabs([
                __('Основная информация') =>
                    Layout::legend("educationalModule", [
                        Sight::make('title', __('Название')),
                        Sight::make("choice_limit", __('Лимит выбора')),
                    ]),
                __("Курсы модуля")        => Layout::rows([]),
            ]),
        ];
    }
}
