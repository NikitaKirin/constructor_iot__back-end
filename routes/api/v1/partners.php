<?php

use App\Http\Controllers\Api\v1\PartnerController;

Route::as('partners.')->group(function () {
    Route::get('partners', [PartnerController::class, 'index'])
        ->name('index');

    Route::get('partners/courses', [PartnerController::class, 'coursesIndex'])
        ->name('courses.index');

    Route::get('partners/courses/{course}', [PartnerController::class, 'courseShow'])
        ->name('courses.show');
});
