<?php

declare(strict_types=1);

namespace Funeralzone\ValueObjects\Enums;

use Funeralzone\ValueObjects\ValueObject;

trait EnumTrait
{
    /**
     * @var int
     */
    protected $value;

    /**
     * @var null|array
     */
    private static $constantsCache;

    /**
     * EnumTrait constructor.
     * @param int $value
     */
    public function __construct(int $value)
    {
        // Value must be a valid option
        if (!in_array($value, static::constantValues())) {
            throw new \InvalidArgumentException($value . ' is not a valid value for this enum.');
        }

        $this->value = $value;
    }

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
        return ($this->toNative() === $object->toNative());
    }

    /**
     * @param int $native
     * @return static
     */
    public static function fromNative($native)
    {
        if (!is_string($native)) {
            throw new \InvalidArgumentException('This method can only instantiate an object using a string.');
        }

        // Native must be a valid constant name
        if (!in_array($native, static::constantKeys())) {
            throw new \InvalidArgumentException($native . ' is not a valid value for this enum.');
        }

        $integer = static::constants()[$native];

        return new static($integer);
    }

    /**
     * @return string
     */
    public function toNative()
    {
        return array_search($this->value, static::constants());
    }

    /**
     * @param $name
     * @param $arguments
     * @return static
     */
    public static function __callStatic($name, $arguments)
    {
        if (!in_array($name, static::constantKeys())) {
            throw new \RuntimeException($name . ' is an invalid value for this enum.');
        }

        return new static(constant(get_called_class() . '::' . $name));
    }

    /**
     * @return array
     */
    private static function constantValues(): array
    {
        $constants = static::constants();
        return array_values($constants);
    }

    /**
     * @return array
     */
    private static function constantKeys(): array
    {
        $constants = static::constants();
        return array_keys($constants);
    }

    /**
     * @return array
     */
    private static function constants(): array
    {
        if (static::$constantsCache !== null) {
            return static::$constantsCache;
        }

        $reflect = new \ReflectionClass(get_called_class());
        return static::$constantsCache = $reflect->getConstants();
    }
}
