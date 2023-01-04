<?php

use App\Http\Controllers\Api\v1\PositionController;

Route::as('positions.')->group(function () {
    Route::get('positions', [PositionController::class, 'index'])->name('index');
});