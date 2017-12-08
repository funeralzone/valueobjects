<?php

declare(strict_types=1);

namespace Funeralzone\ValueObjects\Examples\Book;

use Funeralzone\ValueObjects\Scalars\StringTrait;

final class NonNullISBN implements ISBN
{
    use StringTrait;

    public function __construct($string)
    {
        // TODO: Check valid ISBN
        $this->string = $string;
    }
}
