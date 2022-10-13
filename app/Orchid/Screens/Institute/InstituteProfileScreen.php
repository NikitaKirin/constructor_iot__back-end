<?php

namespace App\Orchid\Screens\Institute;

use App\Http\Requests\Institute\CreateInstituteRequest;
use App\Models\Institute;
use App\Orchid\Layouts\Institute\InstituteEditLayout;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Screen;
use Orchid\Screen\Sight;
use Orchid\Support\Color;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class InstituteProfileScreen extends Screen
{
    public Institute $institute;

    /**
     * Query data.
     *
     * @return array
     */
    public function query( Institute $institute ): iterable {
        return [
            'institute' => $institute,
        ];
    }

    /**
     * Display header name.
     *
     * @return string|null
     */
    public function name(): ?string {
        return __("{$this->institute->title}");
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable {
        return [
            ModalToggle::make(__('Edit'))
                       ->modal('asyncEditInstituteModal')
                       ->method('save')
                       ->asyncParameters(['institute' => $this->institute->id])
                       ->icon('pencil'),
            Button::make(__("Delete"))
                  ->icon('trash')
                  ->type(Color::DANGER())
                  ->confirm(__(Config::get('toasts.confirm.forceDelete')))
                  ->method('destroy', ['id' => $this->institute->id]),
        ];
    }

    /**
     * Views.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable {
        return [

            Layout::modal('asyncEditInstituteModal', InstituteEditLayout::class)
                  ->async('asyncGetInstituteData')
                  ->title(__('Добавить новый институт'))
                  ->applyButton(__('Save')),

            Layout::tabs([
                __('Основная информация') => [

                    Layout::legend("institute", [
                        Sight::make('title', __('Название')),
                        Sight::make("abbreviation", __('Аббревиатура')),
                    ]),
                ],

                __("Образовательные модули") => Layout::rows([]),
            ]),
        ];
    }

    public function asyncGetInstituteData( Institute $institute ): array {
        return [
            'institute' => $institute,
        ];
    }

    public function save( Institute $institute, CreateInstituteRequest $request ) {

        $institute->fill($request->validated())
                  ->save();

        $institute->user()->associate(Auth::user())->save();

        Toast::info(__('Институт успешно сохранен'));
    }


    public function destroy( Request $request ): RedirectResponse {
        Institute::findOrFail($request->input('id'))->forceDelete();

        Toast::success(__(Config::get('toasts.toasts.delete.success')));

        return redirect()->route('platform.institutes');
    }
}
