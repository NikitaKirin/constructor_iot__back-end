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
        $semester = $request->input('semester');
        $educationalModules = EducationalModule::with(['disciplines'])->whereHas('educationalDirections',
            function ( Builder $query ) use ( $educationalDirection ) {
                return $query->where('title', 'ilike', $educationalDirection->title);
            })->when($semester, function ( Builder $query ) use ( $semester ) {
            return $query->whereHas('semesters', function ( Builder $query ) use ( $semester ) {
                return $query->where('id', 'ilike', $semester);
            });
        })->get();

        return new EducationalModuleResourceCollection($educationalModules);
    }
}
