<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\EducationalModule\EducationalModuleResourceCollection;
use App\Models\EducationalDirection;
use App\Models\EducationalModule;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class EducationalModuleController extends Controller
{
    /**
     * Get the list of educational directions' educational modules
     * @param Request $request
     * @param EducationalDirection $educationalDirection
     * @return EducationalModuleResourceCollection
     */
    public function index( Request $request, EducationalDirection $educationalDirection ) {
        $semesterId = $request->input('semesterId');
        $educationalModules = EducationalModule::with(['disciplines'])->whereHas('educationalDirections',
            function ( Builder $query ) use ( $educationalDirection ) {
                return $query->where('title', 'ilike', $educationalDirection->title);
            })->when($semesterId, function ( Builder $query ) use ( $semesterId ) {
            return $query->whereHas('semesters', function ( Builder $query ) use ( $semesterId ) {
                return $query->where('id', 'ilike', $semesterId);
            });
        })->get();

        return new EducationalModuleResourceCollection($educationalModules);
    }
}
