<?php

declare(strict_types=1);

namespace Funeralzone\ValueObjects\Examples\Book;

use Funeralzone\ValueObjects\Scalars\String\BooleanTrait;

final class NonNullISBN implements ISBN
{
    use BooleanTrait;

    public function __construct($string)
    {
        // TODO: Check valid ISBN
        $this->string = $string;
    }
}
