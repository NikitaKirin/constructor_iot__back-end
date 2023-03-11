<?php

namespace App\Actions\FAQ\DTO;

class UpdateFAQData
{
    public function __construct(
        public readonly string $question,
        public readonly string $answer,
    ) {
    }

}
