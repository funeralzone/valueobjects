<?php

declare(strict_types=1);

namespace Funeralzone\ValueObjects\Examples\Book;

use Funeralzone\ValueObjects\Scalars\StringTrait;

final class NonNullISBN implements ISBN
{
    use StringTrait;

    /**
     * NonNullISBN constructor.
     * @param string $string
     */
    public function __construct(string $string)
    {
        // TODO: Check valid ISBN
        $this->string = $string;
    }
}
