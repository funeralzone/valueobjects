<?php

declare(strict_types=1);

namespace Funeralzone\ValueObjects\Examples\Book;

use Funeralzone\ValueObjects\NullTrait;

final class NullISBN implements ISBN
{
    use NullTrait;
}
