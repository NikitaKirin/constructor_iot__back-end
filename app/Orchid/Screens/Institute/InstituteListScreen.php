<?php

namespace App\Orchid\Screens\Institute;

use App\Http\Requests\Institute\CreateInstituteRequest;
use App\Models\Institute;
use App\Orchid\Layouts\Institute\InstituteEditLayout;
use App\Orchid\Layouts\Institute\InstituteListLayout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class InstituteListScreen extends Screen
{
    /**
     * Query data.
     *
     * @return array
     */
    public function query(): iterable {
        return [
            'institutes' => Institute::with('user')->paginate(5),
        ];
    }

    /**
     * Display header name.
     *
     * @return string|null
     */
    public function name(): ?string {
        return __('Список институтов');
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable {
        return [
            /*Link::make(__('Add'))
                ->icon('plus')
                ->route('platform.institutes.create'),*/
            ModalToggle::make(__('Добавить новый'))
                       ->modal('asyncEditInstituteModal')
                       ->method('save')
                       ->icon('plus'),
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
            InstituteListLayout::class,
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

        return redirect()->route('platform.institutes');
    }

    public function remove( Request $request ) {
        Institute::findOrFail($request->get('id'))->forceDelete();

        Toast::info(__('Институт успешно удалён'));
    }
}
