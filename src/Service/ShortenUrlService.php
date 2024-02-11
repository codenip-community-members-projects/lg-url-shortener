<?php

declare(strict_types=1);

namespace App\Service;

use App\Dto\ShortenedUrlDto;
use App\Entity\ShortenedUrl;
use App\Repository\ShortenedUrlRepository;

final readonly class ShortenUrlService
{
    public function __construct(
        private ShortenedUrlRepository $repository,
        private string $host
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

    /**
     * @param \App\Entity\ShortenedUrl $shortenedUrl
     * @return string
     */
    private function buildShortenedUrl(ShortenedUrl $shortenedUrl): string
    {
        return sprintf(
            'https://%s/%s',
            $this->host,
            $shortenedUrl->shortCode()
        );
    }
}
