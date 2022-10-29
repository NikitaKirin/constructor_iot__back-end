<?php

namespace App\Orchid\Layouts\AdmissionCommitteeContactsBlock;

use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Rows;

class AdmissionCommitteeContactsBlockEditLayout extends Rows
{
    /**
     * Used to create the title of a group of form elements.
     *
     * @var string|null
     */
    protected $title;

    /**
     * Get the fields elements to be displayed.
     *
     * @return Field[]
     */
    protected function fields(): iterable {
        return [

            Input::make('address')
                 ->title(__('Адрес'))
                 ->type('text')
                 ->required()
                 ->value($this->query->get('admissionCommitteeContactsBlock')?->address),

            Input::make('phone_number')
                 ->title(__('Номер телефона'))
                 ->type('text')
                 ->mask('+7 (999) 999-99-99')
                 ->required()
                 ->value($this->query->get('admissionCommitteeContactsBlock')?->phone_number),

            Input::make('email')
                 ->title(__('Электронная почта'))
                 ->type('email')
                 ->required()
                 ->value($this->query->get('admissionCommitteeContactsBlock')?->email),
        ];
    }
}
