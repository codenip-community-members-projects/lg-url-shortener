<?php

declare(strict_types=1);

namespace App\Request\Validation;

use Countable;
use IteratorAggregate;
use Traversable;

final readonly class ValidationErrorCollection implements Countable, IteratorAggregate
{
    /** @var ValidationError[] $elements */
    private function __construct(public array $elements)
    {
    }

    public static function createEmpty(): self
    {
        return new self([]);
    }

    public static function fromElements(array $elements): self
    {
        return new self($elements);
    }

    public function count(): int
    {
        return count($this->elements);
    }

    public function getIterator(): Traversable
    {
        yield from $this->elements;
    }
}
