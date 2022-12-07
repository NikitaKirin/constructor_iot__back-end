<?php

namespace App\Orchid\Screens\EducationalModule;

use App\Models\EducationalModule;
use App\Orchid\Layouts\Discipline\DisciplineListLayout;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Screen\Sight;
use Orchid\Support\Color;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class EducationalModuleProfileScreen extends Screen
{
    public EducationalModule $educationalModule;

    /**
     * Query data.
     *
     * @return array
     */
    public function query( EducationalModule $educationalModule ): iterable {
        $educationalModule->load(['educationalDirections', 'disciplines']);
        return [
            'educationalModule'     => $educationalModule,
            'educationalDirections' => $educationalModule->educationalDirections,
            'disciplines'           => $educationalModule->disciplines,
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
                        Sight::make('is_spec', __('Спец-модуль'))
                             ->render(function ( EducationalModule $educationalModule ) {
                                 return $educationalModule->is_spec ? 'Да' : 'Нет';
                             }),
                    ]),
                /*__('Направления')         =>
                    EducationalDirectionListLayout::class,*/

                __("Дисциплины модуля") => DisciplineListLayout::class,
            ]),
        ];
    }

    public function destroy( Request $request ): RedirectResponse {
        EducationalModule::findOrFail($request->input('id'))->forceDelete();

        Toast::success(__(Config::get('toasts.toasts.delete.success')));

        return redirect()->route('platform.educationalModules');
    }
}
