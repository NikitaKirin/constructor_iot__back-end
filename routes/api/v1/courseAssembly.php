<?php

use App\Http\Controllers\Api\v1\CourseAssemblyController;

Route::as('courseAssemblies.')->group(function () {

    Route::get('courseAssemblies/{courseAssembly}', [CourseAssemblyController::class, 'show'])
         ->name('show');

});
