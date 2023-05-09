<?php

use App\Http\Controllers\Api\v1\ProfessionalTrajectoryController;

Route::as('professionalTrajectories.')->prefix('educationalPrograms/')->group(function () {

    Route::get('{educationalProgram}/professionalTrajectories', [ProfessionalTrajectoryController::class, 'index'])
         ->name('index');

    Route::get('professionalTrajectories/{professionalTrajectory}/{courseAssembliesCount?}/{vacanciesCount?}', [ProfessionalTrajectoryController::class, 'show'])
         ->name('show');
});
