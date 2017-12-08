<?php

declare(strict_types=1);

namespace Funeralzone\ValueObjects\Examples\Book;

use Assert\Assert;
use Funeralzone\ValueObjects\Scalars\String\BooleanTrait;

final class NonNullAuthor implements Author
{
    use BooleanTrait;

    public function __construct($string)
    {
        Assert::that($string)->notEmpty();
        $this->string = $string;
    }
}
