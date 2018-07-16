<?php

declare(strict_types=1);

namespace Funeralzone\ValueObjects\Sets;

use Funeralzone\ValueObjects\Nullable;
use Funeralzone\ValueObjects\Set;
use Funeralzone\ValueObjects\ValueObject;

abstract class NullableSet extends Nullable implements Set
{
    /**
     * @var Set
     */
    protected $value;

    /**
     * NullableSet constructor.
     * @param Set $set
     */
    public function __construct(Set $set)
    {
        parent::__construct($set);
    }

    /**
     * @param static $set
     * @return static
     */
    public function add($set)
    {
        return new static($this->value->add($set));
    }

    /**
     * @param static $set
     * @return static
     */
    public function remove($set)
    {
        return new static($this->value->remove($set));
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return $this->value->toArray();
    }

    /**
     * @return static
     */
    public function nonNullValues()
    {
        return new static($this->value->nonNullValues());
    }

    /**
     * @param ValueObject $value
     * @return bool
     */
    public function contains(ValueObject $value): bool
    {
        return $this->value->contains($value);
    }

    /**
     * @return \Traversable
     */
    public function getIterator()
    {
        return $this->value->getIterator();
    }

    /**
     * @param mixed $offset
     * @return bool
     */
    public function offsetExists($offset)
    {
        return $this->value->offsetExists($offset);
    }

    /**
     * @param mixed $offset
     * @return mixed
     */
    public function offsetGet($offset)
    {
        return $this->value->offsetGet($offset);
    }

    /**
     * @param mixed $offset
     * @param mixed $value
     */
    public function offsetSet($offset, $value)
    {
        $this->value->offsetSet($offset, $value);
    }

    /**
     * @param mixed $offset
     */
    public function offsetUnset($offset)
    {
        $this->value->offsetUnset($offset);
    }

    /**
     * @return int
     */
    public function count()
    {
        return $this->value->count();
    }
}
