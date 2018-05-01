<?php

declare(strict_types=1);

namespace Funeralzone\ValueObjects\TestClasses;

use Funeralzone\ValueObjects\ValueObject;

final class NullValue implements ValueObject
{
    public function isNull(): bool
    {
        return true;
    }

    public function isSame(ValueObject $object): bool
    {
        return $object->isNull();
    }

    public static function fromNative($native)
    {
        return new static;
    }

    public function toNative()
    {
        return null;
    }
}
