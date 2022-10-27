<?php

namespace App\Orchid\Screens\AdmissionCommitteeContacts;

use App\Http\Requests\AdmissionCommitteeContacts\CreateAdmissionCommitteeContactsRequest;
use App\Models\AdmissionCommitteeContacts;
use App\Orchid\Layouts\AdmissionCommitteeContacts\AdmissionCommitteeContactsEditLayout;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;
use Orchid\Support\Color;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class AdmissionCommitteeContactsEditScreen extends Screen
{

    /**
     * Query data.
     *
     * @return array
     */
    public function query( AdmissionCommitteeContacts $admissionCommitteeContacts ): iterable {
        return [
            'admissionCommitteeContacts' => $admissionCommitteeContacts,
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
            Layout::block(AdmissionCommitteeContactsEditLayout::class)
                  ->title(__('Основная информация'))
                  ->commands([
                      Button::make(__('Save'))
                            ->type(Color::SUCCESS())
                            ->method('save'),
                  ]),

        ];
    }

    public function save( AdmissionCommitteeContacts $admissionCommitteeContacts, CreateAdmissionCommitteeContactsRequest $request ): RedirectResponse {

        $admissionCommitteeContacts->fill($request->validated())
                                   ->user()
                                   ->associate(Auth::user())
                                   ->save();

        Toast::success(Config::get('toasts.toasts.update.success'));

        return redirect()->route('platform.admissionCommitteeContacts.profile', [
            'admissionCommitteeContacts' =>
                $admissionCommitteeContacts,
        ]);

    }
}
