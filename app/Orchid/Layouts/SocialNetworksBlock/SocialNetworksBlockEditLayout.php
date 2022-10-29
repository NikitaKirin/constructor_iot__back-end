<?php

namespace App\Orchid\Layouts\SocialNetworksBlock;

use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Rows;

class SocialNetworksBlockEditLayout extends Rows
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
            Input::make('telegram')
                 ->type('url')
                 ->title(__('Telegram'))
                 ->value($this->query->get('socialNetworksBlock.data.telegram.url'))
                 ->required(),
            Input::make('vk')
                 ->type('url')
                 ->title(__('Вконтакте'))
                 ->value($this->query->get('socialNetworksBlock.data.vk.url'))
                 ->required(),
        ];
    }
}
