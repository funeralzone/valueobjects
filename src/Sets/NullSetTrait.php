<?php

declare(strict_types=1);

namespace Funeralzone\ValueObjects\Sets;

use Funeralzone\ValueObjects\NullTrait;

trait NullSetTrait
{
    use NullTrait;

    public function getIterator()
    {
        return new NullSetIterator;
    }

    public function offsetExists($offset)
    {
        return false;
    }

    public function offsetGet($offset)
    {
        return null;
    }

    public function offsetSet($offset, $value)
    {
        return;
    }

    public function offsetUnset($offset)
    {
        return;
    }

    public function count()
    {
        return 0;
    }
}
