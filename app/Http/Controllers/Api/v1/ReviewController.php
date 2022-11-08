<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Review\ReviewResourceCollection;
use App\Models\Review;

class ReviewController extends Controller
{
    public function index() {
        return new ReviewResourceCollection(Review::paginate(2));
    }
}
