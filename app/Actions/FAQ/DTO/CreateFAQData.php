<?php

namespace App\Actions\FAQ\DTO;

class CreateFAQData
{
    public function __construct(
        public readonly string $question,
        public readonly string $answer,
    ) {
    }
}
