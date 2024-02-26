<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\UI\API\Request\Validation;

final readonly class ValidationError
{
    private function __construct(
        public string $property,
        public string $message
    )
    {
    }

    public static function create(string $property, string $message): self
    {
        return new self($property, $message);
    }
}
