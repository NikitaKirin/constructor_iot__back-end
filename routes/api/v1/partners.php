<?php

use App\Http\Controllers\Api\v1\PartnerController;

Route::as('partners.')->group(function () {
    Route::get('partners', [PartnerController::class, 'index'])
         ->name('index');
});
