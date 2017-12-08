<?php

declare(strict_types=1);

namespace Funeralzone\ValueObjects\Examples\Fruit;

use Funeralzone\ValueObjects\NullTrait;

final class NullFastening implements Fastening
{
    use NullTrait;
}
