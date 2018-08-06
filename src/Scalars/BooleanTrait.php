<?php

declare(strict_types=1);

namespace Funeralzone\ValueObjects\Scalars;

use Funeralzone\ValueObjects\ValueObject;

trait BooleanTrait
{
    /**
     * @var bool
     */
    protected $bool;

    /**
     * BooleanTrait constructor.
     * @param bool $bool
     */
    public function __construct(bool $bool)
    {
        $this->bool = $bool;
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
     * @param bool $native
     * @return static
     */
    public static function fromNative($native)
    {
        if (!is_bool($native)) {
            throw new \InvalidArgumentException('Can only instantiate this object with a bool.');
        }

        return new static($native);
    }

    /**
     * @return bool
     */
    public function toNative()
    {
        return $this->bool;
    }

    /**
     * @return static
     */
    public static function true()
    {
        return new static(true);
    }

    /**
     * @return static
     */
    public static function false()
    {
        return new static(false);
    }

    /**
     * @return bool
     */
    public function isTrue(): bool
    {
        return ($this->toNative());
    }

    /**
     * @return bool
     */
    public function isFalse(): bool
    {
        return (!$this->toNative());
    }
}
