<?php

declare(strict_types=1);

namespace App\Url\Application\Service;

use App\Shared\Domain\Service\ConfigService;
use App\Url\Application\Dto\ShortenedUrlDto;
use App\Url\Domain\Entity\ShortenedUrl;
use App\Url\Domain\Repository\ShortenedUrlWriteRepository;

final readonly class ShortenUrlService
{
    public function __construct(
        private ShortenedUrlWriteRepository $repository,
        private ConfigService $config
    )
    {
    }

    public function __invoke(string $originalUrl): ShortenedUrlDto
    {
        $shortCode = $this->generateShortCodeFromUrl($originalUrl);

        $shortenedUrl = ShortenedUrl::create($shortCode, $originalUrl);

        $this->repository->save($shortenedUrl);

        return new ShortenedUrlDto($this->buildShortenedUrl($shortenedUrl));
    }

    private function generateShortCodeFromUrl(string $url): string
    {
        $hash = hash('sha256', $url);

        return substr($hash, 8, 7);
    }

    private function buildShortenedUrl(ShortenedUrl $shortenedUrl): string
    {
        return sprintf(
            'https://%s/%s',
            $this->config->getParameter('app.host'),
            $shortenedUrl->shortCode()
        );
    }
}
