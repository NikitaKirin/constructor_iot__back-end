<?php

namespace App\Providers;

use App\Models\Employee;
use App\Models\Partner;
use App\Models\Review;
use App\Observers\EmployeeObserver;
use App\Observers\PartnerObserver;
use App\Observers\ReviewObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];


    protected $observers = [

        Employee::class => [
            EmployeeObserver::class,
        ],

        Partner::class => [
            PartnerObserver::class,
        ],

        Review::class => [
            ReviewObserver::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot() {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     *
     * @return bool
     */
    public function shouldDiscoverEvents() {
        return false;
    }
}
