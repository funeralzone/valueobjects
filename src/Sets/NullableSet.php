<?php

declare(strict_types=1);

namespace Funeralzone\ValueObjects\Sets;

use Funeralzone\ValueObjects\Nullable;
use Funeralzone\ValueObjects\Set;

abstract class NullableSet extends Nullable implements Set
{
    /**
     * @var Set
     */
    protected $value;

    public function __construct(Set $set)
    {
        parent::__construct($set);
    }

    public function getIterator()
    {
        return $this->value->getIterator();
    }

    public function offsetExists($offset)
    {
        return $this->value->offsetExists($offset);
    }

    public function offsetGet($offset)
    {
        return $this->value->offsetGet($offset);
    }

    public function offsetSet($offset, $value)
    {
        $this->value->offsetSet($offset, $value);
    }

    public function offsetUnset($offset)
    {
        $this->value->offsetUnset($offset);
    }

    public function count()
    {
        return $this->value->count();
    }
}
