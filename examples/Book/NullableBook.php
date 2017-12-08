<?php

declare(strict_types=1);

namespace Funeralzone\ValueObjects\Examples\Book;

use Funeralzone\ValueObjects\Nullable;

final class NullableBook extends Nullable implements Book
{
    /**
     * @var Book
     */
    protected $value;

    /**
     * @return Author
     */
    public function getAuthor(): Author
    {
        return $this->value->getAuthor();
    }

    /**
     * @return ISBN
     */
    public function getISBN(): ISBN
    {
        return $this->value->getISBN();
    }

    /**
     * @return string
     */
    protected static function nonNullImplementation(): string
    {
        return NonNullBook::class;
    }

    /**
     * @return string
     */
    protected static function nullImplementation(): string
    {
        return NullBook::class;
    }
}
