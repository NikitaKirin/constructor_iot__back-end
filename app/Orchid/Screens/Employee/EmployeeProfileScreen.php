<?php

namespace App\Orchid\Screens\Employee;

use App\Models\Employee;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Config;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Screen\Sight;
use Orchid\Support\Color;
use Orchid\Support\Facades\Layout;

class EmployeeProfileScreen extends Screen
{
    public Employee $employee;

    /**
     * Query data.
     *
     * @return array
     */
    public function query( Employee $employee ): iterable {
        $employee->load(['photo', 'position']);
        return [
            'employee' => $employee,
        ];
    }

    /**
     * Display header name.
     *
     * @return string|null
     */
    public function name(): ?string {
        return "Сотрудник {$this->employee->full_name}";
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
                ->route('platform.employees.edit', $this->employee),
            Button::make(__('Delete'))
                  ->icon('trash')
                  ->confirm(__('Вы уверены, что хотите удалить сотрудника? Данное действия нельзя будет отменить.'))
                  ->type(Color::DANGER())
                  ->method('destroy'),
        ];
    }

    /**
     * Views.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable {
        return [
            Layout::legend('employee', [
                Sight::make('photo_id', __('Фото'))
                     ->render(function () {
                         $link = $this->employee?->photo?->url() ?? asset(Config::get('constants.avatars.employee.url'));
                         return "<img src=$link width='100' alt='Фото сотрудника'>";
                     }),
                Sight::make('full_name', __('ФИО')),
                Sight::make('email', __('Email')),
                Sight::make('phone_number', __('Номер телефона')),
                Sight::make('address', __('Адрес')),
                Sight::make('audience', __("Аудитория")),
                Sight::make('position_id', __('Должность'))
                     ->render(function () {
                         return $this->employee->position->title;
                     }),
                Sight::make('additional_information', __('Дополнительная информация')),
            ]),
        ];
    }

    public function destroy(): RedirectResponse {
        $this->employee->forceDelete();
        return redirect()->route('platform.employees');
    }
}
