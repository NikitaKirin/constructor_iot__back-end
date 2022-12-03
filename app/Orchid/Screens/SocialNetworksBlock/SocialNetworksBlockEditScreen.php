<?php

namespace App\Orchid\Screens\SocialNetworksBlock;

use App\Http\Requests\SocialNetworksBlock\UpdateSocialNetworksBlockRequest;
use App\Models\SocialNetworksBlock;
use App\Orchid\Layouts\SocialNetworksBlock\SocialNetworksBlockEditLayout;
use Illuminate\Support\Facades\Config;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;
use Orchid\Support\Color;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class SocialNetworksBlockEditScreen extends Screen
{
    public SocialNetworksBlock $socialNetworksBlock;

    /**
     * Query data.
     *
     * @return array
     */
    public function query( SocialNetworksBlock $socialNetworksBlock ): iterable {
        return [
            'socialNetworksBlock' => $socialNetworksBlock,
        ];
    }

    /**
     * Display header name.
     *
     * @return string|null
     */
    public function name(): ?string {
        return __("Изменить социальные сети");
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
            Layout::block(SocialNetworksBlockEditLayout::class)
                  ->commands(
                      Button::make(__('Save'))
                            ->type(Color::SUCCESS())
                            ->method('save', ['id' => $this->socialNetworksBlock->id])
                  ),

        ];
    }

    public function save( UpdateSocialNetworksBlockRequest $request ) {
        $socialNetworksBlock = SocialNetworksBlock::findOrFail($request->input('id'));
        //dd($socialNetworksBlock);
        $socialNetworksBlock->update([
            'data->telegram->url' => $request->input('telegram'),
            'data->vk->url'       => $request->input('vk'),
        ]);
        $socialNetworksBlock->save();

        Toast::success(Config::get('toasts.toasts.update.success'));
    }
}
