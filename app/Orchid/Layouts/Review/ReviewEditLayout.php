<?php

namespace App\Orchid\Layouts\Review;

use Orchid\Screen\Field;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\Cropper;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Layouts\Rows;

class ReviewEditLayout extends Rows
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
            Input::make('author')
                 ->title(__('Автор'))
                 ->type('text')
                 ->required()
                 ->value($this->query->get('review')?->author),

            TextArea::make('text')
                    ->title(__('Основной текст'))
                    ->rows(10)
                    ->required()
                    ->value($this->query->get('review')?->text),

            Input::make('additional_information')
                 ->title(__('Дополнительная информация (курс, направление, год выпуска)'))
                 ->type('text')
                 ->required()
                 ->value($this->query->get('review')?->additional_information),

            CheckBox::make('hidden')
                    ->title(__('Скрыть'))
                    ->sendTrueOrFalse()
                    ->value($this->query->get('review')?->hidden),

            Cropper::make('photo_id')
                   ->targetId()
                   ->title(__("Фото"))
                   ->value($this->query->get('review')?->photo_id),
        ];
    }
}
