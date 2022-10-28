<?php

use App\Http\Controllers\Api\v1\AdmissionCommitteeContactsController;

Route::as('admissionCommitteeContacts.')->group(function () {

    Route::get('admissionCommitteeContacts',
        [AdmissionCommitteeContactsController::class, 'index'])
         ->name('index');
});
