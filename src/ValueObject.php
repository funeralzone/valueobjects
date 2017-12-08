<?php

declare(strict_types=1);

namespace Funeralzone\ValueObjects;

interface ValueObject
{
    /**
     * @return bool
     */
    public function isNull(): bool;

    /**
     * @param ValueObject $object
     * @return bool
     */
    public function isSame(ValueObject $object): bool;

    /**
     * @param mixed $native
     * @return mixed
     */
    public static function fromNative($native);

    /**
     * @return mixed
     */
    public function toNative();
}
