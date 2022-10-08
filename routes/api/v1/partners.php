<?php

use App\Http\Controllers\Api\PartnerController;

Route::as('partners.')->group(function () {
    Route::get('partners', [PartnerController::class, 'index'])
         ->name('index');
});
