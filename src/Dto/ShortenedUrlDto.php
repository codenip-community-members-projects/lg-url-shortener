<?php

declare(strict_types=1);

namespace App\Dto;

final readonly class ShortenedUrlDto
{
    public function __construct(public string $url)
    {
    }
}
