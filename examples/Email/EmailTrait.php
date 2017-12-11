<?php

declare(strict_types=1);

namespace Funeralzone\ValueObjects\Examples\Email;

use Assert\Assert;
use Funeralzone\ValueObjects\Scalars\StringTrait;

trait EmailTrait
{
    use StringTrait;

    /**
     * EmailTrait constructor.
     * @param string $string
     */
    public function __construct(string $string)
    {
        Assert::that($string)->email();
        $this->string = $string;
    }
}
