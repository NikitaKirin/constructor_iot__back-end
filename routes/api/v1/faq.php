<?php

use App\Http\Controllers\Api\v1\FAQController;

Route::as('faq.')->group(function () {

    Route::get('faq', [FAQController::class, 'index'])->name('index');

});
