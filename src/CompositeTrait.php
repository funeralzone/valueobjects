<?php

declare(strict_types=1);

namespace Funeralzone\ValueObjects;

trait CompositeTrait
{
    /**
     * @return bool
     */
    public function isNull(): bool
    {
        return false;
    }

    /**
     * @param ValueObject $object
     * @return bool
     */
    public function isSame(ValueObject $object): bool
    {
        return ($this->toNative() == $object->toNative());
    }

    /**
     * @return array
     */
    public function toNative()
    {
        return $this->propertiesToArray();
    }

    private function propertiesToArray(): array
    {
        return get_object_vars($this);
    }
}
