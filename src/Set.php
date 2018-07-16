<?php

declare(strict_types=1);

namespace Funeralzone\ValueObjects;

interface Set extends ValueObject, \IteratorAggregate, \ArrayAccess, \Countable
{
    /**
     * @param static $set
     * @return static
     */
    public function add($set);

    /**
     * @param static $set
     * @return static
     */
    public function remove($set);

    /**
     * @param ValueObject $value
     * @return bool
     */
    public function contains(ValueObject $value): bool;

    /**
     * @return array
     */
    public function toArray(): array;

    /**
     * @return static
     */
    public function nonNullValues();
}
