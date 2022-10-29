<?php

use App\Http\Controllers\Api\v1\AdmissionCommitteeContactsBlockController;

Route::as('admissionCommitteeContactsBlock.')->group(function () {

    Route::get('admissionCommitteeContactsBlock',
        [AdmissionCommitteeContactsBlockController::class, 'index'])
         ->name('index');
});
