<?php

declare(strict_types=1);

namespace Funeralzone\ValueObjects\Examples\Book;

use Funeralzone\ValueObjects\ValueObject;

interface Book extends ValueObject
{
    public function getAuthor(): Author;
    public function getISBN(): ISBN;
}
