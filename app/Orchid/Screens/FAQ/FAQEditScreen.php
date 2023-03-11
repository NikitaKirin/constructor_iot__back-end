<?php

namespace App\Orchid\Screens\FAQ;

use App\Actions\FAQ\CreateFAQAction;
use App\Actions\FAQ\DestroyFAQAction;
use App\Actions\FAQ\DTO\CreateFAQData;
use App\Actions\FAQ\DTO\UpdateFAQData;
use App\Actions\FAQ\UpdateFAQAction;
use App\Http\Requests\FAQ\CreateFAQRequest;
use App\Http\Requests\FAQ\UpdateFAQRequest;
use App\Models\FAQ;
use App\Orchid\Layouts\FAQ\FAQEditLayout;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;
use Orchid\Support\Color;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class FAQEditScreen extends Screen
{
    public FAQ $faq;

    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(FAQ $faq): iterable {
        return [
            'faq' => $faq,
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string {
        return $this->faq->exists ? __('Изменить данные вопроса') : 'Создать новый вопрос';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable {
        return [
            Button::make(__('Delete'))
                ->type(Color::DANGER())
                ->method('destroy', ['id' => $this->faq->id])
                ->canSee($this->faq->exists),
        ];
    }

    /**
     * The screen's layout elements.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable {
        return [
            Layout::block(FAQEditLayout::class)
                ->title(__('Основная информация'))
                ->description(__('Обновите информацию, заполнив соответсвующее поля.'))
                ->commands([
                    Button::make(__('Create'))
                        ->type(Color::SUCCESS())
                        ->method('create')
                        ->canSee(!$this->faq->exists),
                    Button::make(__('Update'))
                        ->type(Color::SUCCESS())
                        ->method('update')
                        ->canSee($this->faq->exists),
                ]),
        ];
    }

    public function create(CreateFAQRequest $request): RedirectResponse {
        $validated = $request->validated();

        $faq = (new CreateFAQAction())->run(
            new CreateFAQData(
                question: $validated['question'],
                answer: $validated['answer'],
            )
        );

        Toast::success(config('toasts.toasts.update.success'))
            ->autoHide();

        return redirect()->route('platform.faq');
    }

    public function update(FAQ $faq, UpdateFAQRequest $request) {
        $validated = $request->validated();
        $status = (new UpdateFAQAction())->run(
            $faq,
            new UpdateFAQData(
                question: $validated['question'],
                answer: $validated['answer'],
            )
        );
        if ($status) {
            Toast::success(config('toasts.toasts.update.success'));
        } else
            Toast::error(config('toasts.toasts.update.error'));
    }

    public function destroy(Request $request) {

        $status = (new DestroyFAQAction())->run($request);

        if ($status) {
            Toast::success(config('toasts.toasts.delete.success'));
            return redirect()->route('platform.faq');
        } else
            Toast::error(config('toasts.toasts.delete.error'));
    }
}
