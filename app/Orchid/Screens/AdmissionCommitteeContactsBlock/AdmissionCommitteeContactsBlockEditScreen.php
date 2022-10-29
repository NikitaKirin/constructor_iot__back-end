<?php

namespace App\Orchid\Screens\AdmissionCommitteeContactsBlock;

use App\Http\Requests\AdmissionCommitteeContactsBlock\CreateAdmissionCommitteeContactsBlockRequest;
use App\Models\AdmissionCommitteeContactsBlock;
use App\Orchid\Layouts\AdmissionCommitteeContactsBlock\AdmissionCommitteeContactsBlockEditLayout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;
use Orchid\Support\Color;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class AdmissionCommitteeContactsBlockEditScreen extends Screen
{

    /**
     * Query data.
     *
     * @return array
     */
    public function query( AdmissionCommitteeContactsBlock $admissionCommitteeContactsBlock ): iterable {
        return [
            'admissionCommitteeContactsBlock' => $admissionCommitteeContactsBlock,
        ];
    }

    /**
     * Display header name.
     *
     * @return string|null
     */
    public function name(): ?string {
        return __('Изменить контакты отборочной комиссии');
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
            Layout::block(AdmissionCommitteeContactsBlockEditLayout::class)
                  ->title(__('Основная информация'))
                  ->commands([
                      Button::make(__('Save'))
                            ->type(Color::SUCCESS())
                            ->method('save'),
                  ]),

        ];
    }

    public function save( AdmissionCommitteeContactsBlock $admissionCommitteeContactsBlock, CreateAdmissionCommitteeContactsBlockRequest $request ): void {

        $admissionCommitteeContactsBlock->fill($request->validated())
                                        ->user()
                                        ->associate(Auth::user())
                                        ->save();

        Toast::success(Config::get('toasts.toasts.update.success'));
    }
}
