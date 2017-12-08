<?php

declare(strict_types=1);

namespace Funeralzone\ValueObjects\Examples\Book;

use Funeralzone\ValueObjects\NullTrait;

final class NullBook implements Book
{
    use NullTrait;

    public function getAuthor(): Author
    {
        return new NullAuthor;
    }

    public function getISBN(): ISBN
    {
        return new NullISBN;
    }
}
