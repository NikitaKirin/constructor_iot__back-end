<?php

namespace App\Providers;

use App\Models\Employee;
use App\Models\Partner;
use App\Models\Profession;
use App\Models\ProfessionalTrajectory;
use App\Models\Review;
use App\Observers\EmployeeObserver;
use App\Observers\PartnerObserver;
use App\Observers\ProfessionalTrajectoryObserver;
use App\Observers\ProfessionObserver;
use App\Observers\ReviewObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

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

        ProfessionalTrajectory::class => [
            ProfessionalTrajectoryObserver::class,
        ],

        Profession::class => [
            ProfessionObserver::class,
        ]
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
