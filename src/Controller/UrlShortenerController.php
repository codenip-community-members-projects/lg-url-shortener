<?php

declare(strict_types=1);

namespace App\Controller;

use App\Request\ShortenUrlRequest;
use App\Service\ShortenUrlService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class UrlShortenerController extends AbstractController
{
    public function __construct(
        private readonly ShortenUrlService $shortenUrlService
    )
    {
    }

    #[Route('/api/url/shorten', name: 'shorten-url', methods: 'POST')]
    public function __invoke(ShortenUrlRequest $request): Response
    {
        $shortenedUrlDto = $this->shortenUrlService->__invoke($request->url);

        // TODO: Add response subscriber/presenter for shortenedUrlDto
        return new JsonResponse([
                'data' => [
                    'shortened_url' => $shortenedUrlDto->url
                ]
            ],
            Response::HTTP_CREATED
        );
    }
}
