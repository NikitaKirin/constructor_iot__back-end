<?php

use App\Http\Controllers\Api\v1\ProfessionController;

Route::as('professions.')->group(function () {

    Route::get('professions', [ProfessionController::class, 'index'])
        ->name('index');

    Route::get('professions/{profession}', [ProfessionController::class, 'show'])
        ->name('show');
});
