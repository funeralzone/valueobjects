<?php

declare(strict_types=1);

namespace Funeralzone\ValueObjects\Scalars;

use Funeralzone\ValueObjects\ValueObject;

trait IntegerTrait
{
    /**
     * @var int
     */
    protected $int;

    /**
     * IntegerTrait constructor.
     * @param int $int
     */
    public function __construct(int $int)
    {
        $this->int = $int;
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
        if (!is_int($native)) {
            throw new \InvalidArgumentException('Can only instantiate this object with an int.');
        }

        return new static($native);
    }

    /**
     * @return int
     */
    public function toNative()
    {
        return $this->int;
    }
}
