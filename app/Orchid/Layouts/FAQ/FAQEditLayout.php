<?php

namespace App\Orchid\Layouts\FAQ;

use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Layouts\Rows;

class FAQEditLayout extends Rows
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
            Input::make('question')
                ->type('text')
                ->title(__('Вопрос'))
                ->max(255)
                ->required()
                ->value($this->query->get('faq.question')),

            TextArea::make('answer')
                ->title(__('Ответ'))
                ->max(255)
                ->required()
                ->value($this->query->get('faq.answer')),
        ];
    }
}
