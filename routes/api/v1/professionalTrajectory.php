<?php

use App\Http\Controllers\Api\v1\ProfessionalTrajectoryController;

Route::as('professionalTrajectories.')->group(function () {

    Route::get('professionalTrajectories', [ProfessionalTrajectoryController::class, 'index'])
         ->name('index');

    Route::get('professionalTrajectories/{professionalTrajectory}', [ProfessionalTrajectoryController::class, 'show'])
         ->name('show');
});
