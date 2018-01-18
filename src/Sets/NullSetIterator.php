<?php

declare(strict_types=1);

namespace Funeralzone\ValueObjects\Sets;

use Iterator;

final class NullSetIterator implements Iterator
{
    public function current()
    {
        return null;
    }

    public function next()
    {
        return;
    }

    public function key()
    {
        return null;
    }

    public function valid()
    {
        return false;
    }

    public function rewind()
    {
        return;
    }
}
