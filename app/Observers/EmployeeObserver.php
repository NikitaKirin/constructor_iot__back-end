<?php

namespace App\Observers;

use App\Models\Employee;

class EmployeeObserver
{
    public function created( Employee $employee ) {

    }

    public function updated( Employee $employee ) {
    }

    public function deleted( Employee $employee ) {
        $employee->photo->delete();
    }

    public function restored( Employee $employee ) {
    }

    public function forceDeleted( Employee $employee ) {
        $employee->photo->delete();
    }
}
