<?php

declare(strict_types=1);

namespace Funeralzone\ValueObjects\Sets;

use Funeralzone\ValueObjects\NullTrait;
use Funeralzone\ValueObjects\ValueObject;

trait NullSetTrait
{
    use NullTrait;

    /**
     * @param static $set
     * @return static
     */
    public function add($set)
    {
        return $set;
    }

    /**
     * @param static $set
     * @return static
     */
    public function remove($set)
    {
        return $this;
    }

    /**
     * @param ValueObject $value
     * @return bool
     */
    public function contains(ValueObject $value): bool
    {
        return false;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [];
    }

    /**
     * @return static
     */
    public function nonNullValues()
    {
        return $this;
    }

    /**
     * @return NullSetIterator
     */
    public function getIterator()
    {
        return new NullSetIterator;
    }

    /**
     * @param $offset
     * @return bool
     */
    public function offsetExists($offset)
    {
        return false;
    }

    /**
     * @param $offset
     * @return null
     */
    public function offsetGet($offset)
    {
        return null;
    }

    /**
     * @param $offset
     * @param $value
     */
    public function offsetSet($offset, $value)
    {
        return;
    }

    /**
     * @param $offset
     */
    public function offsetUnset($offset)
    {
        return;
    }

    /**
     * @return int
     */
    public function count()
    {
        return 0;
    }
}
