<?php

declare(strict_types=1);

namespace Funeralzone\ValueObjects\Examples\Book;

use Assert\Assert;
use Funeralzone\ValueObjects\Scalars\StringTrait;

final class NonNullAuthor implements Author
{
    use StringTrait;

    /**
     * NonNullAuthor constructor.
     * @param string $string
     */
    public function __construct(string $string)
    {
        Assert::that($string)->notEmpty();
        $this->string = $string;
    }
}
