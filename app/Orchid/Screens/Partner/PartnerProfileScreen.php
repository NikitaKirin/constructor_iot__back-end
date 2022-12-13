<?php

namespace App\Orchid\Screens\Partner;

use App\Models\Partner;
use App\Orchid\Layouts\Course\CourseListLayout;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Screen\Sight;
use Orchid\Support\Color;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class PartnerProfileScreen extends Screen
{

    public Partner $partner;

    /**
     * Query data.
     *
     * @return array
     */
    public function query(Partner $partner): iterable
    {
        $partner->load('courses');
        return [
            "partner" => $partner,
            "courses" => $partner->courses,
        ];
    }

    /**
     * Display header name.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return "{$this->partner->title}";
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Link::make(__('Edit'))
                ->icon("pencil")
                ->route("platform.partners.edit", $this->partner),
            Button::make(__("Delete"))
                ->icon('trash')
                ->type(Color::DANGER())
                ->confirm(__("Вы уверены, что хотите удалить партнера? Данное действие нельзя будет отменить."))
                ->method('destroy', ['id' => $this->partner->id]),
        ];
    }

    /**
     * Views.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [
            Layout::tabs([
                __('Основная информация') =>
                    Layout::legend("partner", [
                        Sight::make('logo_id', __('Логотип'))
                            ->render(function () {
                                $link = $this->partner?->logo?->url() ?? asset(
                                    Config::get('constants.avatars.employee.url')
                                );
                                return "<img src='$link' width='100' alt='Логотип компании: {$this->partner->title}'";
                            }),
                        Sight::make('title', __("Название компании")),
                        Sight::make("description", __('Описание'))
                            ->render(function () {
                                return $this->partner->description;
                            }),
                    ]),
                __("Курсы партнёра") => CourseListLayout::class,
            ]),

        ];
    }

    public function destroy(Request $request): RedirectResponse
    {
        Partner::findOrFail($request->get('id'))->forceDelete();

        Toast::success(__('Партнер успешно удален'));
        return redirect()->route('platform.partners');
    }
}
