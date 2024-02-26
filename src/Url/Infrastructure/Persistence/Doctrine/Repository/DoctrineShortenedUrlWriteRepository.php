<?php

namespace App\Url\Infrastructure\Persistence\Doctrine\Repository;

use App\Url\Domain\Entity\ShortenedUrl;
use App\Url\Domain\Repository\ShortenedUrlWriteRepository;
use Doctrine\Persistence\ManagerRegistry;

final readonly class DoctrineShortenedUrlWriteRepository implements ShortenedUrlWriteRepository
{
    public function __construct(private ManagerRegistry $registry)
    {
    }

    public function save(ShortenedUrl $shortenedUrl): void
    {
        $entityManager = $this->registry->getManager();
        $entityManager->persist($shortenedUrl);
        $entityManager->flush();
    }
}
