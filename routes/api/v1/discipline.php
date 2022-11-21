<?php

use App\Http\Controllers\Api\v1\DisciplineController;

Route::as('disciplines.')->group(function () {

    Route::get('disciplines/{discipline}', [DisciplineController::class, 'show'])
         ->name('show');

});
