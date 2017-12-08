<?php

declare(strict_types=1);

namespace Funeralzone\ValueObjects\Examples\Email;

use Funeralzone\ValueObjects\ValueObject;

final class UserEmail implements ValueObject
{
    use EmailTrait;
}
