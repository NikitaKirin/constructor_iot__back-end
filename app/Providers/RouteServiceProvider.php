<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     *
     * @return void
     */
    public function boot() {
        $this->configureRateLimiting();

        $this->routes(function () {
            Route::middleware('api')
                ->prefix('api/v1')
                ->group(function () {
                    require base_path('routes/api.php');
                    require base_path('routes/api/v1/partners.php');
                    require base_path('routes/api/v1/reviews.php');
                    require base_path('routes/api/v1/admissionCommitteeContactsBlock.php');
                    require base_path('routes/api/v1/socialNetworksBlock.php');
                    require base_path('routes/api/v1/discipline.php');
                    require base_path('routes/api/v1/educationalProgram.php');
                    require base_path('routes/api/v1/professionalTrajectory.php');
                    require base_path('routes/api/v1/semester.php');
                    require base_path('routes/api/v1/courseAssembly.php');
                    require base_path('routes/api/v1/position.php');
                    require base_path('routes/api/v1/employee.php');
                    require base_path('routes/api/v1/profession.php');
                    require base_path('routes/api/v1/headHunter.php');
                    require base_path('routes/api/v1/faq.php');
                    require base_path('routes/api/v1/entityStat.php');
                }
                );

            Route::middleware('web')
                ->group(base_path('routes/web.php'));
        });
    }

    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    protected function configureRateLimiting() {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });
    }
}
