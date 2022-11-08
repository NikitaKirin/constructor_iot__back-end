<?php

use App\Http\Controllers\Api\v1\EducationalModuleController;

Route::as('educationalModules.')->prefix('educationalDirections/')->group(function () {

    Route::get('{educationalDirection}/educationalModules/{semester?}',
        [EducationalModuleController::class, 'index'])->name('index');

});
