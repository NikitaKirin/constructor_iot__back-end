<?php

use App\Http\Controllers\Api\v1\EntityStatController;

Route::prefix('stat')->as('stat.')->group(function () {

    Route::post('/', [EntityStatController::class, 'store'])->name('store');

});
