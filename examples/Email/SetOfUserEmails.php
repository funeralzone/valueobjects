<?php

declare(strict_types=1);

namespace Funeralzone\ValueObjects\Examples\Email;

use Funeralzone\ValueObjects\Sets\SetOfValueObjects;

final class SetOfUserEmails extends SetOfValueObjects
{
    protected function typeToEnforce(): string
    {
        return UserEmail::class;
    }

    public static function valuesShouldBeUnique(): bool
    {
        return true;
    }
}
