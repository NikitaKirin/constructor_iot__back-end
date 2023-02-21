<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProfessionalTrajectory\ProfessionalTrajectoryResource;
use App\Http\Resources\ProfessionalTrajectory\ProfessionalTrajectoryResourceCollection;
use App\Models\ProfessionalTrajectory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class ProfessionalTrajectoryController extends Controller
{
    public function index(Request $request) {
        $withProfessions = $request->input('withProfessions', false);
        if ($withProfessions) {
            return new ProfessionalTrajectoryResourceCollection(ProfessionalTrajectory::with(['professions'])
                ->orderBy('id')
                ->get());
        }
        return new ProfessionalTrajectoryResourceCollection(ProfessionalTrajectory::orderBy('id')->get());
    }

    public function show(ProfessionalTrajectory $professionalTrajectory, Request $request) {
        if ($request->input('disciplinesCount', false)) {
            return new ProfessionalTrajectoryResource($professionalTrajectory->loadCount('disciplines'));
        }
        return new ProfessionalTrajectoryResource($professionalTrajectory);
    }
}
