<?php

declare(strict_types=1);

namespace Funeralzone\ValueObjects\Scalars;

use Funeralzone\ValueObjects\ValueObject;

trait FloatTrait
{
    /**
     * @var float
     */
    protected $float;

    /**
     * FloatTrait constructor.
     * @param float $float
     */
    public function __construct(float $float)
    {
        $this->float = $float;
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
        return ($this->toNative() == $object->toNative());
    }

    /**
     * @param float $native
     * @return static
     */
    public static function fromNative($native)
    {
        if (!is_float($native) && !is_int($native)) {
            throw new \InvalidArgumentException('Can only instantiate this object with a float or int.');
        }

        return new static($native);
    }

    /**
     * @return float
     */
    public function toNative()
    {
        return $this->float;
    }
}
