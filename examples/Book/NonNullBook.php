<?php

declare(strict_types=1);

namespace Funeralzone\ValueObjects\Examples\Book;

use Funeralzone\ValueObjects\CompositeTrait;

final class NonNullBook implements Book
{
    use CompositeTrait;

    private $author;
    private $isbn;

    public function __construct(Author $author, ISBN $isbn)
    {
        $this->author = $author;
        $this->isbn = $isbn;
    }

    public function getAuthor(): Author
    {
        return $this->author;
    }

    public function getISBN(): ISBN
    {
        return $this->isbn;
    }

    public static function fromNative($native)
    {
        return new static(
            new NonNullAuthor($native['author']),
            new NonNullISBN($native['isbn'])
        );
    }
}
