<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Symfony\Service;

use App\Shared\Domain\Service\ConfigService;
use RuntimeException;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpKernel\KernelInterface;

final readonly class SymfonyConfigService implements ConfigService
{
    public function __construct(private ParameterBagInterface $parameters)
    {
    }

    public function getParameter(string $parameterKey): mixed
    {
        $parameter = $this->parameters->get($parameterKey);

        if ($parameter !== null) {
            return $parameter;
        }

        throw new RuntimeException(
            sprintf
            ('Parameter <%s> is not defined', $parameterKey)
        );
    }
}
