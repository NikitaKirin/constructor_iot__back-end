<?php

use App\Http\Controllers\Api\v1\DisciplineController;

Route::as('disciplines.')->prefix('educationalPrograms/')->group(function () {
    Route::get(
        'disciplines/{discipline}/{withCourseAssemblies?}',
        [DisciplineController::class, 'show']
    )->name('show');

    Route::get(
        '{educationalProgram}/disciplines/{paginate?}',
        [DisciplineController::class, 'index']
    )->name('index');
});
