<?php

namespace App\Orchid\Screens\AdmissionCommitteeContacts;

use App\Models\AdmissionCommitteeContacts;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Screen\Sight;
use Orchid\Support\Facades\Layout;

class AdmissionCommitteeContactsProfileScreen extends Screen
{
    public AdmissionCommitteeContacts $admissionCommitteeContacts;

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
        return 'Контакты отборочной комиссии';
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable {
        return [
            Link::make(__('Edit'))
                ->icon('pencil')
                ->route('platform.admissionCommitteeContacts.edit', $this->admissionCommitteeContacts),
        ];
    }

    /**
     * Views.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable {
        return [
            Layout::legend('admissionCommitteeContacts',
                [
                    Sight::make('address', __("Адрес")),

                    Sight::make('phone_number', __('Номер телефона')),

                    Sight::make('email', __('Электронная почта')),
                ]),
        ];
    }
}
