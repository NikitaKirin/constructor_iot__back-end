<?php

namespace App\Actions\Course\DTO;

class UpdateCourseData
{

    public function __construct(
        public readonly string $title,
        public readonly string $description,
        public readonly int    $seatLimit,
        public readonly int    $realizationId,
        public readonly ?int   $videoId = null,
        public readonly ?int   $presentationId = null,
        public readonly array  $documentsIds = [],
        public readonly ?int   $disciplineId = null,
        public readonly array  $courseAssembliesIds = [],
        public readonly ?int   $partnerId = null,
    ) {

    }
}
