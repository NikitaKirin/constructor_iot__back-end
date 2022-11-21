<?php

use App\Http\Controllers\Api\v1\SemesterController;

Route::as('semesters.')->group(function () {

    Route::get('semesters', [SemesterController::class, 'index'])->name('index');

});
