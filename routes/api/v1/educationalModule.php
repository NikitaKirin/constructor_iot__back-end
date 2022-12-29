<?php

use App\Http\Controllers\Api\v1\EducationalModuleController;

Route::as('educationalModules.')->prefix('educationalDirections/')->group(function () {
    Route::get(
        'educationalModules/{educationalModule}/{withDisciplines?}',
        [EducationalModuleController::class, 'show']
    )->name('show');

    Route::get(
        '{educationalDirection}/educationalModules/{paginate?}',
        [EducationalModuleController::class, 'index']
    )->name('index');
});
