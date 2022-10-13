<?php

namespace App\Orchid\Screens\Institute;

use App\Http\Requests\Institute\CreateInstituteRequest;
use App\Models\Institute;
use App\Orchid\Layouts\Institute\InstituteEditLayout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;
use Orchid\Support\Color;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class InstituteEditScreen extends Screen
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
        return $this->institute->exists ? 'Изменить данные об институте' : 'Создать институт';
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable {
        return [
            /*Button::make(__('Save'))
                  ->icon('check')
                  ->method('save'),*/
        ];
    }

    /**
     * Views.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable {
        return [
            Layout::block([
                InstituteEditLayout::class,
            ])
                  ->title(__('Информация об институте'))
                  ->commands(
                      Button::make(__('Save'))
                            ->type(Color::DEFAULT())
                            ->icon('check')
                            ->method('save')
                  ),
        ];
    }

    public function save( Institute $institute, CreateInstituteRequest $request ) {

        $institute->fill($request->validated())
                  ->save();

        Toast::info(__(Config::get('toasts.toasts.update.success')))
             ->autoHide();

        return redirect()->route('platform.institutes');
    }
}
