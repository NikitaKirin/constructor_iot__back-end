<?php

namespace App\Orchid\Screens\Partner;

use App\Http\Requests\Partner\CreatePartnerRequest;
use App\Models\Partner;
use App\Orchid\Layouts\Partner\PartnerEditLayout;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;
use Orchid\Support\Color;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class PartnerEditScreen extends Screen
{
    public Partner $partner;

    /**
     * Query data.
     *
     * @return array
     */
    public function query( Partner $partner ): iterable {
        $partner->load(['logo', 'courses']);
        return [
            'partner' => $partner,
        ];
    }

    /**
     * Display header name.
     *
     * @return string|null
     */
    public function name(): ?string {
        return $this->partner->exists ? $this->partner->title : "Добавить нового партнера";
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable {
        return [];
    }

    /**
     * Views.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable {
        return [
            Layout::block(PartnerEditLayout::class)
                  ->title("Основная информация")
                  ->commands([
                      Button::make(__('Save'))
                            ->type(Color::SUCCESS())
                            ->method("save"),
                      Button::make(__("Delete"))
                            ->canSee($this->partner->exists())
                            ->type(Color::DANGER())
                            ->method("destroy", ['id' => $this->partner->id]),
                  ]),
        ];
    }

    public function save( Partner $partner, CreatePartnerRequest $request ): RedirectResponse {
        $partner->fill($request->validated())
                ->user()
                ->associate(Auth::user())->save();

        if ( $request->input('logo_id') ) {
            $partner->attachment()
                    ->sync($request->input('logo_id', []));
            $partner->logo_id = $partner->attachment()->first()?->id;
            $partner->save();
        }

        else {
            $partner->logo->delete();
        }

        Toast::success(__('Партнер успешно обновлен'));

        return redirect()->route('platform.partners');

    }

    public function destroy( Request $request ) {
        Partner::findOrFail($request->get('id'))->forceDelete();

        Toast::success(__('Партнёр успешно удален'));
        return redirect()->route('platform.partners');
    }
}
