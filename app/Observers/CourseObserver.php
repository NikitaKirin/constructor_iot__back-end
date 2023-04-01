<?php

namespace App\Observers;

use App\Models\Course;

class CourseObserver
{
    public function created(Course $course) {

    }

    public function updated(Course $course) {
    }

    public function deleted(Course $course) {
        $course->video->delete();
        $course->presentation->delete();
        $course->attachment->each->delete();
    }

    public function restored(Course $course) {
    }

    public function forceDeleted(Course $course) {
        $course->video->delete();
        $course->presentation->delete();
        $course->attachment->each->delete();
    }
}
