<?php

namespace App\Orchid\Screens\Employee;

use App\Models\Employee;
use App\Orchid\Layouts\Employee\EmployeeListLayout;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Toast;

class EmployeeListScreen extends Screen
{
    /**
     * Query data.
     *
     * @return array
     */
    public function query(): iterable {
        return [
            'employees' => Employee::filters()->paginate(10),
        ];
    }

    /**
     * Display header name.
     *
     * @return string|null
     */
    public function name(): ?string {
        return 'Список сотрудников';
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable {
        return [
            Link::make(__('Add'))
                ->icon('plus')
                ->route('platform.employees.create'),
        ];
    }

    /**
     * Views.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable {
        return [
            EmployeeListLayout::class,
        ];
    }

    public function remove( Request $request ) {
        Employee::findOrFail($request->get('id'))->forceDelete();

        Toast::success(__('Сотрудник успешно удален'));
    }
}
