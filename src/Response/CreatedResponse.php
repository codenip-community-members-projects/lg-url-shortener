<?php

declare(strict_types=1);

namespace App\Response;

final readonly class CreatedResponse
{
    public function __construct(public object $object)
    {
    }
}
