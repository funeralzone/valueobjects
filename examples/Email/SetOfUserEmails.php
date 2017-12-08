<?php

declare(strict_types=1);

namespace Funeralzone\ValueObjects\Examples\Email;

use Funeralzone\ValueObjects\Sets\SetOfValueObjects;

final class SetOfUserEmails extends SetOfValueObjects
{
    /**
     * @return string
     */
    protected function typeToEnforce(): string
    {
        return UserEmail::class;
    }

    /**
     * @return bool
     */
    public static function valuesShouldBeUnique(): bool
    {
        return true;
    }
}
