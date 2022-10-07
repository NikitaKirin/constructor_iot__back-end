<?php

namespace App\Observers;

use App\Models\Review;

class ReviewObserver
{
    public function created( Review $review ) {

    }

    public function updated( Review $review ) {
    }

    public function deleted( Review $review ) {
        $review->photo->delete();
    }

    public function restored( Review $review ) {
    }

    public function forceDeleted( Review $review ) {
        $review->photo->delete();
    }
}
