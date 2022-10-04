<?php

namespace App\Orchid\Screens\EducationalDirection;

use App\Http\Requests\EducationalDirection\CreateEducationalDirectionRequest;
use App\Models\EducationalDirection;
use App\Models\Institute;
use App\Orchid\Layouts\EducationalDirection\EducationalDirectionEditLayout;
use App\Orchid\Layouts\EducationalDirection\EducationalDirectionListLayout;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class EducationalDirectionListScreen extends Screen
{
    /**
     * Query data.
     *
     * @return array
     */
    public function query(): iterable {
        return [
            'educationalDirections' => EducationalDirection::with(['institute', 'user'])->paginate(10),
        ];
    }

    /**
     * Display header name.
     *
     * @return string|null
     */
    public function name(): ?string {
        return __('Направления подготовки УрФУ');
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable {
        return [
            ModalToggle::make(__('Добавить новое'))
                       ->modal('asyncEditEducationalDirectionModal')
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
            Layout::modal('asyncEditEducationalDirectionModal', EducationalDirectionEditLayout::class)
                  ->async('asyncGetEducationalDirectionData')
                  ->title(__('Добавить новое направление'))
                  ->applyButton(__('Save')),
            EducationalDirectionListLayout::class,
        ];
    }

    public function asyncGetEducationalDirectionData( EducationalDirection $educationalDirection ): array {
        return [
            'educationalDirection' => $educationalDirection,
        ];
    }

    public function save( EducationalDirection $educationalDirection, CreateEducationalDirectionRequest $request ): RedirectResponse {

        $educationalDirection->fill($request->validated())
                             ->institute()->associate($request->get('institute'))
                             ->save();

        $educationalDirection->user()->associate(Auth::user())
                             ->save();

        Toast::info(__('Программа подготовки успешно сохранена'));

        return redirect()->route('platform.educationalDirections');
    }

    public function remove( Request $request ) {
        EducationalDirection::findOrFail($request->get('id'))->forceDelete();

        Toast::info(__('Направление подготовки успешно успешно удалено'));
    }
}
