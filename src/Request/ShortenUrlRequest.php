<?php

declare(strict_types=1);

namespace App\Request;

use App\Exception\InvalidRequest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Url;

final readonly class ShortenUrlRequest extends ApiRequest
{
    private function __construct(public string $url)
    {
    }

    public static function fromRequest(Request $request): self
    {
        $jsonContent = $request->getContent();
        $data = json_decode($jsonContent, true);

        if (empty($data) || !key_exists('url', $data)) {
            throw InvalidRequest::withInvalidPayload('Invalid Payload. A valid url must be provided.');
        }

        self::validate('url', $data['url'], [new NotBlank(), new Url()]);

        return new self($data['url']);
    }
}
