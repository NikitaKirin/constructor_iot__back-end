<?php

use App\Http\Controllers\Api\v1\EducationalProgramController;

Route::as('educationalPrograms.')->group(function () {

    Route::get('educationalPrograms', [EducationalProgramController::class, 'index'])
         ->name('index');

});
