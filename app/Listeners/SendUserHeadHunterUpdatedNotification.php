<?php

namespace App\Listeners;

use App\Events\HeadHunterUpdatedEvent;
use App\Notifications\TaskStatusNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendUserHeadHunterUpdatedNotification
{
    private string $title;
    private string $message;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        $this->title = "Обновление данных из сервиса HeadHunter";
        $this->message = "Система успешно обновила данные с HeadHunter!";
    }

    /**
     * Handle the event.
     *
     * @param HeadHunterUpdatedEvent $event
     * @return void
     */
    public function handle(HeadHunterUpdatedEvent $event)
    {
        $notification = new TaskStatusNotification($this->title, $this->message);
        $event->user->notify($notification);
    }
}
