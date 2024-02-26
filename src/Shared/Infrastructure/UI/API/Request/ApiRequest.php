<?php

namespace App\Shared\Infrastructure\UI\API\Request;

use App\Shared\Domain\Exception\InvalidRequest;
use App\Shared\Infrastructure\UI\API\Request\Validation\ValidationError;
use App\Shared\Infrastructure\UI\API\Request\Validation\ValidationErrorCollection;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\Validation;

abstract readonly class ApiRequest
{
    abstract public static function fromRequest(Request $request);

    protected static function validate(string $propertyName, $email, array $constraints = []): void
    {
        $validator = Validation::createValidator();
        $violations = $validator->validate($email, $constraints);

        if ($violations->count() === 0) {
            return;
        }

        $errors = array_map(
            fn(ConstraintViolation $violation) => ValidationError::create($propertyName, $violation->getMessage()),
            iterator_to_array($violations->getIterator())
        );

        throw InvalidRequest::withValidationErrors(ValidationErrorCollection::fromElements($errors));
    }
}
