<?php

use App\Http\Controllers\Api\v1\ReviewController;

Route::as('reviews.')->group(function () {
    Route::get('reviews', [ReviewController::class, 'index'])
         ->name('index');
});
