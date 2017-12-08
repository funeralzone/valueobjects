<?php

declare(strict_types=1);

namespace Funeralzone\ValueObjects\Examples\Book;

use Funeralzone\ValueObjects\ValueObject;

interface Book extends ValueObject
{
    /**
     * @return Author
     */
    public function getAuthor(): Author;

    /**
     * @return ISBN
     */
    public function getISBN(): ISBN;
}
