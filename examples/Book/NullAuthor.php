<?php

declare(strict_types=1);

namespace Funeralzone\ValueObjects\Examples\Book;

use Funeralzone\ValueObjects\NullTrait;

final class NullAuthor implements Author
{
    use NullTrait;
}
