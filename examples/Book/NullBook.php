<?php

declare(strict_types=1);

namespace Funeralzone\ValueObjects\Examples\Book;

use Funeralzone\ValueObjects\NullTrait;

final class NullBook implements Book
{
    use NullTrait;

    /**
     * @return Author
     */
    public function getAuthor(): Author
    {
        return new NullAuthor;
    }

    /**
     * @return ISBN
     */
    public function getISBN(): ISBN
    {
        return new NullISBN;
    }
}
