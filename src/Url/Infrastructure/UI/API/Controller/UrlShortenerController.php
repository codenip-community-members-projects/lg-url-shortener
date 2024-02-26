<?php

declare(strict_types=1);

namespace App\Url\Infrastructure\UI\API\Controller;

use App\Shared\Infrastructure\UI\API\Response\CreatedResponse;
use App\Url\Application\Service\ShortenUrlService;
use App\Url\Infrastructure\UI\API\Request\ShortenUrlRequest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class UrlShortenerController extends AbstractController
{
    public function __construct(
        private readonly ShortenUrlService $shortenUrlService
    )
    {
    }

    public function __invoke(ShortenUrlRequest $request): CreatedResponse
    {
        $shortenedUrlDto = $this->shortenUrlService->__invoke($request->url);

        return new CreatedResponse($shortenedUrlDto);
    }
}
