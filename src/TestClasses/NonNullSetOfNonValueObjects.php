<?php

declare(strict_types=1);

namespace Funeralzone\ValueObjects\TestClasses;

use Funeralzone\ValueObjects\Sets\NonNullSet;

final class NonNullSetOfNonValueObjects extends NonNullSet
{
    protected function typeToEnforce(): string
    {
        return NonValueObject::class;
    }

    public static function valuesShouldBeUnique(): bool
    {
        return true;
    }
}
