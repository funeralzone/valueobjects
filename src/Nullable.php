<?php

declare(strict_types=1);

namespace Funeralzone\ValueObjects;

abstract class Nullable implements ValueObject
{
    /**
     * @var ValueObject
     */
    protected $value;

    /**
     * Nullable constructor.
     * @param ValueObject $value
     */
    public function __construct(ValueObject $value)
    {
        $this->value = $value;
    }

    /**
     * @return bool
     */
    public function isNull(): bool
    {
        return $this->value->isNull();
    }

    /**
     * @param ValueObject $object
     * @return bool
     */
    public function isSame(ValueObject $object): bool
    {
        return $this->value->isSame($object);
    }

    /**
     * @param mixed $native
     * @return static
     */
    public static function fromNative($native)
    {
        $nonNullImplementation = static::nonNullImplementation();
        $nullImplementation = static::nullImplementation();

        //Based on whether the native value is null, wrap an instance of either the nonNull/null implementation of the V.O.
        if ($native === null) {
            $nullObject = call_user_func($nullImplementation . '::fromNative', $native);
            return new static($nullObject);
        } else {
            $nonNullObject = call_user_func($nonNullImplementation . '::fromNative', $native);
            return new static($nonNullObject);
        }
    }

    /**
     * @return static
     */
    public static function null()
    {
        return static::fromNative(null);
    }

    /**
     * @return mixed
     */
    public function toNative()
    {
        return $this->value->toNative();
    }

    /**
     * @return string
     */
    abstract protected static function nonNullImplementation(): string;

    /**
     * @return string
     */
    abstract protected static function nullImplementation(): string;
}
