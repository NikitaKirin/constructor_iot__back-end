<?php

namespace App\Orchid\Screens\EducationalProgram;

use App\Http\Requests\EducationalProgram\CreateEducationalProgramRequest;
use App\Models\EducationalProgram;
use App\Orchid\Layouts\EducationalProgram\EducationalProgramEditLayout;
use App\Orchid\Layouts\EducationalProgram\EducationalProgramListLayout;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class EducationalProgramListScreen extends Screen
{
    /**
     * Query data.
     *
     * @return array
     */
    public function query(): iterable {
        return [
            'educationalPrograms' => EducationalProgram::with(['institute', 'user'])
                                                           ->filters()
                                                           ->defaultSort('id')
                                                           ->paginate(10),
        ];
    }

    /**
     * Display header name.
     *
     * @return string|null
     */
    public function name(): ?string {
        return __('Образовательные программы ИРИТ-РТФ');
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable {
        return [
            ModalToggle::make(__('Добавить новую'))
                       ->modal('asyncEducationalProgramModal')
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
            Layout::modal('asyncEducationalProgramModal', EducationalProgramEditLayout::class)
                  ->async('asyncGetEducationalProgramData')
                  ->title(__('Добавить новую образовательную программу'))
                  ->applyButton(__('Save')),
            EducationalProgramListLayout::class,
        ];
    }

    public function asyncGetEducationalProgramData(EducationalProgram $educationalProgram ): array {
        return [
            'educationalProgram' => $educationalProgram,
        ];
    }

    public function save(EducationalProgram $educationalProgram, CreateEducationalProgramRequest $request ): RedirectResponse {

        $educationalProgram->fill($request->validated())
                             ->institute()->associate($request->get('institute'))
                             ->save();

        if ( is_null($request->get('passing_scores')) ) {
            $educationalProgram->passing_scores = [
                [
                    'year'          => null,
                    'passing_score' => null,
                ],
            ];
        }

        $educationalProgram->user()->associate(Auth::user())
                             ->save();

        Toast::success(config('toasts.toasts.update.success'));

        return redirect()->route('platform.educationalPrograms');
    }

    public function remove( Request $request ) {
        EducationalProgram::findOrFail($request->get('id'))->forceDelete();

        Toast::success(config('toasts.toasts.delete.success'));
    }
}
