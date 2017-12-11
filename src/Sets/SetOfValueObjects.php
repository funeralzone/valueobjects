<?php

declare(strict_types=1);

namespace Funeralzone\ValueObjects\Sets;

use ChrisHarrison\ArrayOf\ImmutableArrayOf;
use Funeralzone\ValueObjects\ValueObject;

abstract class SetOfValueObjects extends ImmutableArrayOf implements ValueObject
{
    /**
     * SetOfValueObjects constructor.
     * @param array $input
     * @throws SetsCanOnlyContainValueObjects
     */
    public function __construct(array $input = [])
    {
        if (!is_a($this->typeToEnforce(), ValueObject::class, true)) {
            throw new SetsCanOnlyContainValueObjects;
        }

        if (static::valuesShouldBeUnique()) {
            $input = static::uniqueInput($input);
        }

        parent::__construct($input);
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
        $compare1 = $this->toNative();
        $compare2 = $object->toNative();
        sort($compare1);
        sort($compare2);

        return ($compare1 == $compare2);
    }

    /**
     * @param array $native
     * @return static
     */
    public static function fromNative($native)
    {
        return new static(array_map(function ($item) {
            return call_user_func((new static)->typeToEnforce() . '::fromNative', $item);
        }, $native));
    }

    /**
     * @return array
     */
    public function toNative()
    {
        return array_map(function (ValueObject $object) {
            return $object->toNative();
        }, (array) $this);
    }

    /**
     * @param static $set
     * @return static
     */
    public function add($set)
    {
        return new static(array_merge((array) $this, (array) $set));
    }

    /**
     * @param static $set
     * @return static
     */
    public function remove($set)
    {
        $output = $this;
        foreach ((array) $set as $object) {
            $output = $output->removeByValue($object);
        }
        return $output;
    }

    /**
     * @param ValueObject $object
     * @return static
     */
    private function removeByValue(ValueObject $object)
    {
        return new static(array_values(array_filter((array) $this, function (ValueObject $compare) use ($object) {
            return (!$compare->isSame($object));
        })));
    }

    private static function uniqueInput(array $input): array
    {
        $unique = [];

        foreach ($input as $object) {
            /* @var ValueObject $object */
            $match = false;
            foreach ($unique as $compare) {
                /* @var ValueObject $compare */
                if ($object->isSame($compare)) {
                    $match = true;
                }
            }
            if (!$match) {
                $unique[] = $object;
            }
        }

        return $unique;
    }

    /**
     * @return bool
     */
    abstract public static function valuesShouldBeUnique(): bool;
}
