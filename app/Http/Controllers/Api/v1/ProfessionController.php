<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Profession\ProfessionResource;
use App\Http\Resources\Profession\ProfessionResourceCollection;
use App\Models\Profession;
use Illuminate\Http\Request;

class ProfessionController extends Controller
{
    public function index(Request $request) {
        $withProfessionalTrajectories = $request->boolean('withProfessionalTrajectories');
        $paginate = $request->integer('paginate', default: 10);
        if ($withProfessionalTrajectories) {
            $professions = Profession::with(['professionalTrajectories'])
                ->orderBy('id')
                ->paginate($paginate);
        } else {
            $professions = Profession::orderBy('id')
                ->paginate($paginate);
        }
        return new ProfessionResourceCollection($professions);
    }

    public function show(Profession $profession, Request $request) {
        $withProfessionalTrajectories = $request->boolean('withProfessionalTrajectories');
        if ($withProfessionalTrajectories) {
            return new ProfessionResource($profession->load('professionalTrajectories'));
        }
        return new ProfessionResource($profession);
    }
}
