<?php

declare(strict_types=1);

namespace App\Exception;

use App\Request\Validation\ValidationError;
use App\Request\Validation\ValidationErrorCollection;
use Exception;
use Throwable;

final class InvalidRequest extends Exception
{
    private ValidationErrorCollection $validationErrors;

    private function __construct(string $message = '', int $code = 0, ?Throwable $previous = null)
    {
        $this->validationErrors = ValidationErrorCollection::createEmpty();

        parent::__construct($message, $code, $previous);
    }

    public static function withValidationErrors(ValidationErrorCollection $validationErrors): self
    {
        $exception = new self('Invalid Request');

        $exception->validationErrors = $validationErrors;

        return $exception;
    }

    public static function withInvalidPayload(string $message): self
    {
        $exception = new self('Invalid Request');

        $exception->validationErrors = ValidationErrorCollection::fromElements([
            ValidationError::create('payload',$message)
        ]);

        return $exception;
    }

    public function validationErrors(): ValidationErrorCollection
    {
        return $this->validationErrors;
    }
}
