<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProfessionalTrajectory\ProfessionalTrajectoryResourceCollection;
use App\Models\ProfessionalTrajectory;

class ProfessionalTrajectoryController extends Controller
{
    public function index() {
        return new ProfessionalTrajectoryResourceCollection(ProfessionalTrajectory::orderBy('id')->get());
    }
}
