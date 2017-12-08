<?php

declare(strict_types=1);

namespace Funeralzone\ValueObjects\TestClasses;

use Funeralzone\ValueObjects\ValueObject;

final class TestValueObject implements ValueObject
{
    private $value;

    public function __construct($value)
    {
        $this->value = $value;
    }

    public function isNull(): bool
    {
        return ($this->value === null);
    }

    public function isSame(ValueObject $object): bool
    {
        return ($this->value == $object->toNative());
    }

    public static function fromNative($native)
    {
        return new self($native);
    }

    public function toNative()
    {
        return $this->value;
    }
}
