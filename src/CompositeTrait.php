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
        return array_reduce($this->toNative(), function ($carry, $value) {
            if (!$carry) {
                return $carry;
            }
            return ($value === null);
        }, true);
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
        return array_map(function (ValueObject $valueObject) {
            return $valueObject->toNative();
        }, $this->propertiesToArray());
    }

    /**
     * @return array
     */
    private function propertiesToArray(): array
    {
        return get_object_vars($this);
    }
}
