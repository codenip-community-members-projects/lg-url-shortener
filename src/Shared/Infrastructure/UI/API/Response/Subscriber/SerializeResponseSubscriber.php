<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\UI\API\Response\Subscriber;

use App\Shared\Infrastructure\UI\API\Response\CreatedResponse;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Serializer\SerializerInterface;

final readonly class SerializeResponseSubscriber implements EventSubscriberInterface
{
    private const JSON_FORMAT = 'json';

    public function __construct(private SerializerInterface $serializer)
    {
    }

    public static function getSubscribedEvents(): array
    {
        return [KernelEvents::VIEW => '__invoke'];
    }

    public function __invoke(ViewEvent $event): void
    {
        $controllerResult = $event->getControllerResult();
        $statusCode = Response::HTTP_OK;

        if ($controllerResult === null) {
            $this->setEmptyResponse($event);
            return;
        }

        if ($controllerResult instanceof CreatedResponse) {
            $controllerResult = $controllerResult->object;
            $statusCode = Response::HTTP_CREATED;
        }

       $content = $this->serializer->normalize(
            $controllerResult,
            self::JSON_FORMAT,
            $this->getContextClassForNormalization($controllerResult)
        );

        $response = new JsonResponse($content, $statusCode);

        $event->setResponse($response);
    }

    private function getContextClassForNormalization(mixed $response): array
    {
        if (!is_object($response)) {
            return [];
        }

        return [
            'class' => $response::class
        ];
    }

    private function setEmptyResponse(ViewEvent $event): void
    {
        $emptyResponse = new JsonResponse(null, Response::HTTP_NO_CONTENT);
        $event->setResponse($emptyResponse);
    }
}
