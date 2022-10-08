<?php

namespace App\Orchid\Layouts\Partner;

use Orchid\Screen\Field;
use Orchid\Screen\Fields\Cropper;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Quill;
use Orchid\Screen\Layouts\Rows;

class PartnerEditLayout extends Rows
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
                 ->title(__('Название компании'))
                 ->required()
                 ->value($this->query->get('partner.title')),

            Quill::make('description')
                 ->title(__('Описание'))
                 ->toolbar(["text", "color", "header", "list", "format"])
                 ->required()
                 ->value($this->query->get('partner.description')),

            Cropper::make('logo_id')
                   ->targetId()
                   ->value($this->query->get('partner')?->logo_id),
        ];
    }
}
