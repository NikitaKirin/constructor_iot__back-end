<?php

namespace App\Orchid\Layouts\Employee;

use App\Models\Employee;
use App\Models\Position;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Layouts\Rows;

class EmployeeEditLayout extends Rows
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
            Input::make('full_name')
                 ->title(__('ФИО сотрудника'))
                 ->type('text')
                 ->value($this->query->get('employee.full_name'))
                 ->required(),

            Input::make('email')
                 ->title(__('Адрес электронной почты'))
                 ->type('email')
                 ->value($this->query->get('employee.email')),

            Input::make('phone_number')
                 ->title(__('Номер телефона'))
                 ->type('text')
                 ->mask('+7 (999) 999-99-99')
                 ->value($this->query->get('employee.phone_number')),

            Input::make('address')
                 ->title(__('Адрес'))
                 ->type('text')
                 ->value($this->query->get('employee.address')),

            Input::make('audience')
                 ->title(__('Аудитория'))
                 ->type('text')
                 ->value($this->query->get('employee.audience')),

            Input::make('additional_information')
                 ->title('Дополнительная информация')
                 ->type('text')
                 ->value($this->query->get('employee.additional_information')),

            Relation::make('position_id')
                  ->title('Должность')
                  ->fromModel(Position::class, 'title')
                  ->required()
                  ->value($this->query->get('employee.position.id')),
        ];
    }
}
