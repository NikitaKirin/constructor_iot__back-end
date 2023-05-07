<?php

namespace App\Actions\Course;

use App\Actions\Course\DTO\UpdateCourseData;
use App\Models\Course;
use Illuminate\Support\Facades\Auth;

class UpdateCourseAction
{
    public function run(Course $course, UpdateCourseData $data): bool {
        $course->documents()->sync($data->documentsIds);
        $course->courseAssemblies()->sync($data->courseAssembliesIds);
        return $course->update([
            'title'           => $data->title,
            'description'     => $data->description,
            'realization_id'  => $data->realizationId,
            'video_id'        => $data->videoId,
            'presentation_id' => $data->presentationId,
            'discipline_id'   => $data->disciplineId,
            'partner_id'      => $data->partnerId,
            'user_id'         => Auth::id(),
        ]);
    }
}
