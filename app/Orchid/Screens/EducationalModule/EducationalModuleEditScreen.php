<?php

namespace App\Orchid\Screens\EducationalModule;

use App\Http\Requests\EducationalModule\CreateEducationalModuleRequest;
use App\Models\EducationalModule;
use App\Orchid\Layouts\EducationalModule\EducationalModuleEditLayout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;
use Orchid\Support\Color;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class EducationalModuleEditScreen extends Screen
{
    public EducationalModule $educationalModule;

    /**
     * Query data.
     *
     * @return array
     */
    public function query( EducationalModule $educationalModule ): iterable {
        return [
            "educationalModule" => $educationalModule,
        ];
    }

    /**
     * Display header name.
     *
     * @return string|null
     */
    public function name(): ?string {
        return $this->educationalModule->exists ? __("Изменить модуль: {$this->educationalModule->title}") : __('Создать новый образовательный модуль');
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable {
        return [
        ];
    }

    /**
     * Views.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable {
        return [
            Layout::block(EducationalModuleEditLayout::class)
                  ->title(__('Основная информация'))
                  ->description(__('Обновите информацию об образовательном модуле, заполнив соответсвующее поля.'))
                  ->commands([
                      Button::make(__('Save'))
                            ->type(Color::SUCCESS())
                            ->method('save'),
                      Button::make(__('Delete'))
                            ->confirm(__(Config::get('toasts.confirm.forceDelete')))
                            ->type(Color::DANGER())
                            ->canSee($this->educationalModule->exists)
                            ->method('remove', ['id' => $this->educationalModule->id]),
                  ]),
        ];
    }

    public function save( EducationalModule $educationalModule, CreateEducationalModuleRequest $request ) {

        $educationalModule->fill($request->validated())
                          ->user()->associate(Auth::user())
                          ->save();

        $educationalModule->semesters()
                          ->sync($request->get('semesters', []));

        $educationalModule->educationalPrograms()
                          ->sync($request->get('educationalPrograms', []));

        $educationalModule->disciplines()
                          ->sync($request->get('disciplines', []));

        Toast::success(__('Образовательный модуль успешно обновлен'))
             ->autoHide();

        //return redirect()->route('platform.educationalModules');
    }

    public function remove( Request $request ) {
        EducationalModule::findOrFail($request->input('id'))->forceDelete();

        Toast::success(__('Образовательный модуль успешно удален'))
             ->autoHide();

        return redirect()->route('platform.educationalModules');
    }
}
