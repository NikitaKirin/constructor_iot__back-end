<?php

namespace App\Listeners;

use App\Events\HeadHunterUpdatingEvent;
use App\Notifications\TaskStatusNotification;

class SendUserHeadHunterUpdatingNotification
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
        $this->message = "Система начала обновлять данные с сервиса HeadHunter. Это займет определенное время.";
    }

    /**
     * Handle the event.
     *
     * @param HeadHunterUpdatingEvent $event
     * @return void
     */
    public function handle(HeadHunterUpdatingEvent $event)
    {
        $notification = new TaskStatusNotification($this->title, $this->message);
        $event->user->notify($notification);
    }
}
