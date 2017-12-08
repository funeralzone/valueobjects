<?php

declare(strict_types=1);

namespace Funeralzone\ValueObjects;

trait NullTrait
{
    /**
     * @return bool
     */
    public function isNull(): bool
    {
        return true;
    }

    /**
     * @param ValueObject $object
     * @return bool
     */
    public function isSame(ValueObject $object): bool
    {
        return ($object->toNative() === null);
    }

    /**
     * @param mixed $native
     * @return static
     */
    public static function fromNative($native)
    {
        return new static;
    }

    /**
     * @return null
     */
    public function toNative()
    {
        return null;
    }
}
