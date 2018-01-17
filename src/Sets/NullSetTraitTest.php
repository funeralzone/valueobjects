<?php

// @codingStandardsIgnoreFile

declare(strict_types=1);

namespace Funeralzone\ValueObjects\Sets;

use function array_key_exists;
use Exception;
use Funeralzone\ValueObjects\Set;
use PHPUnit\Framework\TestCase;

final class NullSetTraitTest extends TestCase
{
    public function test_offsetGet_throws_exception()
    {
        $test = new _NullSetTrait;

        $this->expectException(Exception::class);
        $test['anything'];
    }

    public function test_offsetUnset_throws_exception()
    {
        $test = new _NullSetTrait;

        $this->expectException(Exception::class);
        unset($test['anything']);
    }

    public function test_count_returns_zero()
    {
        $test = new _NullSetTrait;

        $this->assertEquals(0, count($test));
    }

    public function test_offsetExists_returns_false()
    {
        $test = new _NullSetTrait;

        $this->assertFalse(array_key_exists('any', $test));
    }

    public function test_offsetSet_throws_exception()
    {
        $test = new _NullSetTrait;

        $this->expectException(Exception::class);
        $test['any'] = 'foo';
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