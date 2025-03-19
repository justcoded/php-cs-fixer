<?php

declare(strict_types=1);

namespace JustCoded\PhpCsFixer\DTO;

class CodeFixerResult
{
    public function __construct(
        public readonly bool $successful,
        public readonly string $output,
    ) {}

    public static function make(bool $successful, string $output): static
    {
        return new static($successful, $output);
    }
}
