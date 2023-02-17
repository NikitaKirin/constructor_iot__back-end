<?php

namespace App\Observers;

use App\Models\Profession;

class ProfessionObserver
{
    public function created(Profession $profession) {

    }

    public function updated(Profession $profession) {
    }

    public function deleted(Profession $profession) {
        $profession->photo->delete();
    }

    public function restored(Profession $profession) {
    }

    public function forceDeleted(Profession $profession) {
        $profession->photo->delete();
    }
}
