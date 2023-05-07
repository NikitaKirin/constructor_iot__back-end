<?php

namespace App\Actions\Course\DTO;

class CreateCourseData
{
    public function __construct(
        public readonly string $title,
        public readonly string $description,
        public readonly int $realizationId,
        public readonly ?int $videoId = null,
        public readonly ?int $presentationId = null,
        public readonly array $documentsIds = [],
        public readonly array $courseAssemblyIds = [],
        public readonly ?int $partnerId = null,
    ){

    }
}
