<?php

namespace App\Orchid\Screens\Employee;

use App\Http\Requests\Employee\EmployeeCreateRequest;
use App\Models\Employee;
use App\Orchid\Layouts\Employee\EmployeeEditLayout;
use Illuminate\Support\Facades\Auth;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;
use Orchid\Support\Color;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class EmployeeEditScreen extends Screen
{

    public Employee $employee;

    /**
     * Query data.
     *
     * @return array
     */
    public function query( Employee $employee ): iterable {
        return [
            'employee' => $employee,
            'position' => $employee->position
        ];
    }

    /**
     * Display header name.
     *
     * @return string|null
     */
    public function name(): ?string {
        return $this->employee->exists() ? 'Изменить данные сотрудника' : 'Создать нового сотрудника';
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
            Layout::block(EmployeeEditLayout::class)
                  ->title('Основная информация')
                  ->description('Обновите информацию о сотруднике, заполнив соответсвующее поля.')
                  ->commands([
                      Button::make(__('Save'))
                            ->type(Color::SUCCESS())
                            ->method('save'),
                  ]),

        ];
    }

    public function save( Employee $employee, EmployeeCreateRequest $request ) {
        $employee->fill($request->validated())
                 ->user()->associate(Auth::user())
                 ->save();

        Toast::success('Пользователь успешно обновлен');

        return redirect()->route('platform.employees');
    }
}
