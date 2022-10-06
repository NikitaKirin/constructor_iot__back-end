<?php

namespace App\Observers;

use App\Models\Partner;

class PartnerObserver
{
    public function created( Partner $partner ) {

    }

    public function updated( Partner $partner ) {
    }

    public function deleted( Partner $partner ) {
        $partner->logo->delete();
    }

    public function restored( Partner $partner ) {
    }

    public function forceDeleted( Partner $partner ) {
        $partner->logo->delete();
    }
}
