<?php

use App\Http\Controllers\Api\v1\EducationalDirectionController;

Route::as('educationalDirections.')->group(function () {

    Route::get('educationalDirections', [EducationalDirectionController::class, 'index'])
         ->name('index');

});
