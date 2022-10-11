<?php

namespace App\Orchid\Screens\Semester;

use App\Models\Semester;
use App\Orchid\Layouts\Semester\SemesterEditLayout;
use App\Orchid\Layouts\Semester\SemesterListLayout;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Layouts\Modal;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;

class SemesterListScreen extends Screen
{
    /**
     * Query data.
     *
     * @return array
     */
    public function query(): iterable {
        return [
            'semesters' => Semester::all(),
        ];
    }

    /**
     * Display header name.
     *
     * @return string|null
     */
    public function name(): ?string {
        return __('Список семестров');
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable {
        return [
            /*ModalToggle::make(__('Add'))
                       ->icon('plus')
                       ->async()
                       ->method('asyncEditSemesterModal'),*/
        ];
    }

    /**
     * Views.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable {
        return [
            /*Layout::modal('asyncEditSemesterModal', SemesterEditLayout::class)
                  ->async('asyncGetSemesterData')
                  ->title(__("Добавить новый"))
                  ->applyButton(__('Сохранить')),*/
            SemesterListLayout::class,
        ];
    }

    public function asyncGetSemesterData( Semester $semester ): array {
        return [
            'semester' => $semester,
        ];
    }
}
