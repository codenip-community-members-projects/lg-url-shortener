<?php

declare(strict_types=1);

namespace App\Response\Presenter;

use App\Dto\ShortenedUrlDto;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

final readonly class ShortenedUrlDtoPresenter implements NormalizerInterface
{
    public function normalize(mixed $object, ?string $format = null, array $context = []): array|string|int|float|bool|\ArrayObject|null
    {
        /** @var ShortenedUrlDto $object */
        return [
            'data' => [
                'shortened_url' => $object->url
            ]
        ];
    }

    public function supportsNormalization(mixed $data, ?string $format = null, array $context = []): bool
    {
        return $data instanceof ShortenedUrlDto;
    }

    public function getSupportedTypes(?string $format): array
    {
        return [ShortenedUrlDto::class => true];
    }
}
