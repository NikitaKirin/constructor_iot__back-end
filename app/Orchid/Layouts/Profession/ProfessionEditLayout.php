<?php

namespace App\Orchid\Layouts\Profession;

use App\Models\ProfessionalTrajectory;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Fields\Upload;
use Orchid\Screen\Layouts\Rows;

class ProfessionEditLayout extends Rows
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
            Input::make('title')
                ->title(__('Название'))
                ->type('text')
                ->value($this->query->get('profession.title'))
                ->required(),

            TextArea::make('description')
                ->title(__('Описание'))
                ->rows(5)
                ->value($this->query->get('profession.description'))
                ->required(),

            Relation::make('professional_trajectories.')
                ->title(__('Профессиональные траектории'))
                ->fromModel(ProfessionalTrajectory::class, 'title')
                ->multiple()
                ->value($this->query->get('profession')->professionalTrajectories),

            Input::make('headHunter_title')
                ->title(__('Поисковая фраза для сервиса HeadHunter'))
                ->popover(__("Используется для поиска вакансий"))
                ->type('text')
                ->value($this->query->get('profession.headHunter_title'))
                ->required(),

            Input::make('vacancies_count')
                ->title(__('Количество вакансий по данным HeadHunter'))
                ->type('number')
                ->value($this->query->get('profession.vacancies_count'))
                ->disabled(),

            Input::make('maximal_salary')
                ->title(__('Максимальная зарплата по данным HeadHunter'))
                ->type('number')
                ->value($this->query->get('profession.maximal_salary'))
                ->disabled(),

            Input::make('minimal_salary')
                ->title(__('Минимальная зарплата по данным HeadHunter'))
                ->type('number')
                ->value($this->query->get('profession.minimal_salary'))
                ->disabled(),

            Input::make('median_salary')
                ->title(__('Медианная зарплата по данным HeadHunter'))
                ->type('number')
                ->value($this->query->get('profession.median_salary'))
                ->disabled(),

            Upload::make('photo_id')
                ->title(__('Фото'))
                ->targetId()
                ->maxFiles(1)
                ->acceptedFiles('.png,.svg,.jpg')
                ->value($this->query->get('profession')?->photo_id),
        ];
    }
}
