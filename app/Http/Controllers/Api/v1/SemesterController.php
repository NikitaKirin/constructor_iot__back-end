<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Semester\SemesterResourceCollection;
use App\Models\Semester;

class SemesterController extends Controller
{
    public function index() {
        return new SemesterResourceCollection(Semester::all());
    }
}
