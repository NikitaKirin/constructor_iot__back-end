<?php

namespace App\Orchid\Screens\AdmissionCommitteeContactsBlock;

use App\Models\AdmissionCommitteeContactsBlock;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Screen\Sight;
use Orchid\Support\Facades\Layout;

class AdmissionCommitteeContactsBlockProfileScreen extends Screen
{
    public AdmissionCommitteeContactsBlock $admissionCommitteeContactsBlock;

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
                ->route('platform.admissionCommitteeContactsBlock.edit', $this->admissionCommitteeContactsBlock),
        ];
    }

    /**
     * Views.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable {
        return [
            Layout::legend('admissionCommitteeContactsBlock',
                [
                    Sight::make('address', __("Адрес")),

                    Sight::make('phone_number', __('Номер телефона')),

                    Sight::make('email', __('Электронная почта')),
                ]),
        ];
    }
}
