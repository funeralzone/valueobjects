<?php

// @codingStandardsIgnoreFile

declare(strict_types=1);

namespace Funeralzone\ValueObjects\Sets;

use Funeralzone\ValueObjects\Set;
use PHPUnit\Framework\TestCase;

final class NullSetTraitTest extends TestCase
{
    public function test_offsetGet_returns_null()
    {
        $test = new _NullSetTrait;
        $this->assertNull($test['anything']);
    }

    public function test_offsetUnset_throws_no_exception()
    {
        $test = new _NullSetTrait;
        unset($test['anything']);
        $this->assertTrue(true);
    }

    public function test_count_returns_zero()
    {
        $test = new _NullSetTrait;
        $this->assertEquals(0, count($test));
    }

    public function test_offsetExists_returns_false()
    {
        $test = new _NullSetTrait;
        $this->assertFalse(isset($test['any']));
    }

    public function test_offsetSet_throws_no_exception()
    {
        $test = new _NullSetTrait;
        $test['any'] = 'foo';
        $this->assertTrue(true);
    }

    public function test_can_iterate()
    {
        $test = new _NullSetTrait;

        $i = 0;
        foreach ($test as $i) {
            $i++;
        }

        $this->assertEquals(0, $i);
    }
}

final class _NullSetTrait implements Set
{
    use NullSetTrait;
}