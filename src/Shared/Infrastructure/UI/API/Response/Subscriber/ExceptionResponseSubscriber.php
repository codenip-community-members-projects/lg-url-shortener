<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\UI\API\Response\Subscriber;

use App\Shared\Domain\Exception\InvalidRequest;
use App\Shared\Infrastructure\UI\API\Response\ExceptionResponseStatusCode;
use App\Shared\Infrastructure\UI\API\Response\Presenter\ValidationErrorPresenter;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;

final readonly class ExceptionResponseSubscriber implements EventSubscriberInterface
{
    public function __construct(private ValidationErrorPresenter $validationErrorPresenter)
    {
    }

    public static function getSubscribedEvents(): array
    {
        return [KernelEvents::EXCEPTION => '__invoke'];
    }

    public function __invoke(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();
        $statusCode = ExceptionResponseStatusCode::EXCEPTION_STATUS_CODE_MAPPING[$exception::class] ?? Response::HTTP_INTERNAL_SERVER_ERROR;
        $data = ['errors' => $exception->getMessage()];

        if ($exception instanceof InvalidRequest) {
            $data['errors'] = $this->validationErrorPresenter->__invoke($exception->validationErrors());
        }

        $response = new JsonResponse(
            $data,
            $statusCode,
        );

        $event->setResponse($response);
    }
}
