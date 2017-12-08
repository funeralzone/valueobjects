<?php

declare(strict_types=1);

namespace Funeralzone\ValueObjects\Examples\Fruit;

use Funeralzone\ValueObjects\Nullable;

final class NullableFastening extends Nullable implements Fastening
{
    /**
     * @return string
     */
    protected static function nonNullImplementation(): string
    {
        return NonNullFastening::class;
    }

    /**
     * @return string
     */
    protected static function nullImplementation(): string
    {
        return NullFastening::class;
    }
}
