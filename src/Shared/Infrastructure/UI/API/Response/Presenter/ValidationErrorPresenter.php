<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\UI\API\Response\Presenter;

use App\Shared\Infrastructure\UI\API\Request\Validation\ValidationError;
use App\Shared\Infrastructure\UI\API\Request\Validation\ValidationErrorCollection;

final readonly class ValidationErrorPresenter
{
    public function __invoke(ValidationErrorCollection $errors): array
    {
        return array_map(static function (ValidationError $error) {
            return [
                'property' => $error->property,
                'message' => $error->message
            ];
        }, iterator_to_array($errors->getIterator()));
    }
}
