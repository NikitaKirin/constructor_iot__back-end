<?php

namespace App\Observers;

use App\Models\ProfessionalTrajectory;

class ProfessionalTrajectoryObserver
{
    public function created( ProfessionalTrajectory $professionalTrajectory ) {

    }

    public function updated( ProfessionalTrajectory $professionalTrajectory ) {
    }

    public function deleted( ProfessionalTrajectory $professionalTrajectory ) {
        $professionalTrajectory->attachment->each->delete();
    }

    public function restored( ProfessionalTrajectory $professionalTrajectory ) {
    }

    public function forceDeleted( ProfessionalTrajectory $professionalTrajectory ) {
        $professionalTrajectory->attachment->each->delete();
    }
}
