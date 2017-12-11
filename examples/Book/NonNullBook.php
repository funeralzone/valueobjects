<?php

declare(strict_types=1);

namespace Funeralzone\ValueObjects\Examples\Book;

use Funeralzone\ValueObjects\CompositeTrait;

final class NonNullBook implements Book
{
    use CompositeTrait;

    /**
     * @var Author
     */
    private $author;

    /**
     * @var ISBN
     */
    private $isbn;

    /**
     * NonNullBook constructor.
     * @param Author $author
     * @param ISBN $isbn
     */
    public function __construct(Author $author, ISBN $isbn)
    {
        $this->author = $author;
        $this->isbn = $isbn;
    }

    /**
     * @return Author
     */
    public function getAuthor(): Author
    {
        return $this->author;
    }

    /**
     * @return ISBN
     */
    public function getISBN(): ISBN
    {
        return $this->isbn;
    }

    /**
     * @param array $native
     * @return static
     */
    public static function fromNative($native)
    {
        return new static(
            NonNullAuthor::fromNative($native['author']),
            NonNullISBN::fromNative($native['isbn'])
        );
    }
}
