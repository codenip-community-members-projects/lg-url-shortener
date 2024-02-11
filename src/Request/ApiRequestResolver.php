<?php

declare(strict_types=1);

namespace App\Request;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;

final readonly class ApiRequestResolver implements ValueResolverInterface
{
    public function __construct()
    {
    }

    public function resolve(Request $request, ArgumentMetadata $argument): iterable
    {
        $class = $argument->getType();

        if ($class === null) {
            return null;
        }

        /** @var ApiRequest $class */
        yield $class::fromRequest($request);
    }
}
