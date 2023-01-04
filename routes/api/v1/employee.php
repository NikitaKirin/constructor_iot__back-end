<?php

use App\Http\Controllers\Api\v1\EmployeeController;

Route::as('employees.')->group(function () {
    Route::get('employees/{positionId?}', [EmployeeController::class, 'index'])
        ->name('index');
});