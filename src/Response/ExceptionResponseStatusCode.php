<?php

declare(strict_types=1);

namespace App\Response;

use App\Exception\InvalidRequest;
use Symfony\Component\HttpFoundation\Response;

final readonly class ExceptionResponseStatusCode
{
    public const EXCEPTION_STATUS_CODE_MAPPING = [
        InvalidRequest::class => Response::HTTP_BAD_REQUEST
    ];
}
