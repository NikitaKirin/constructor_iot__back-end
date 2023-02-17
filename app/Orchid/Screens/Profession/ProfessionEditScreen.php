<?php

namespace App\Orchid\Screens\Profession;

use App\Http\Requests\Profession\CreateOrUpdateProfessionRequest;
use App\Models\Profession;
use App\Orchid\Layouts\Profession\ProfessionEditLayout;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;
use Orchid\Support\Color;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class ProfessionEditScreen extends Screen
{
    public Profession $profession;

    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(Profession $profession): iterable {
        $profession->load(['photo', 'professionalTrajectories']);
        return [
            "profession" => $profession,
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string {
        return $this->profession->exists ? __("Изменить данные о профессии") : __('Добавить новую профессию');
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable {
        return [
            Button::make(__('Delete'))
                ->icon('trash')
                ->method('remove', ['id' => $this->profession->id])
                ->type(Color::DANGER())
                ->canSee($this->profession->exists),
        ];
    }

    /**
     * The screen's layout elements.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable {
        return [
            Layout::block(
                ProfessionEditLayout::class
            )
                ->title(__('Основная информация'))
                ->commands([
                    Button::make(__('Save'))
                        ->type(Color::SUCCESS())
                        ->method('save'),
                ]),
        ];
    }

    public function save(Profession $profession, CreateOrUpdateProfessionRequest $request) {

        $profession->fill($request->validated())
            ->user()->associate(Auth::user())
            ->save();

        $profession->professionalTrajectories()
            ->sync($request->input('professional_trajectories', []));

        if ($request->input('photo_id')) {
            $profession->attachment()
                ->sync($request->input('photo_id', []));
            $profession->photo_id = $profession->attachment()->first()?->id;
            $profession->save();
        } else {
            $profession->photo->delete();
        }

        Toast::success(config('toasts.toasts.update.success'));
    }

    public function remove(Request $request): RedirectResponse {
        Profession::findOrFail($request->input('id'))->forceDelete();

        Toast::success(__(Config::get('toasts.toasts.delete.success')))
            ->autoHide();

        return redirect()->route('platform.professions');
    }
}
