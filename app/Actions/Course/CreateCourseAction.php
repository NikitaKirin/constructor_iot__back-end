<?php

namespace App\Actions\Course;

use App\Actions\Course\DTO\CreateCourseData;
use App\Models\Course;
use Illuminate\Support\Facades\Auth;

class CreateCourseAction
{
    public function run(CreateCourseData $data): Course {
        $course = Course::create([
            'title'              => $data->title,
            'description'        => $data->description,
            'seat_limit'         => $data->seatLimit,
            'realization_id'     => $data->realizationId,
            'video_id'           => $data->videoId,
            'presentation_id'    => $data->presentationId,
            'course_assembly_id' => $data->courseAssemblyId,
            'partner_id'         => $data->partnerId,
            'user_id'            => Auth::id(),
        ]);
        $course->documents()->sync($data->documentsIds);
        return $course;
    }
}
