<?php

// @codingStandardsIgnoreFile

declare(strict_types=1);

namespace Funeralzone\ValueObjects\Sets;

use Funeralzone\ValueObjects\Set;
use Funeralzone\ValueObjects\TestClasses\TestValueObject;
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

    public function test_add_returns_whatever_was_added()
    {
        $test = new _NullSetTrait;
        $add = new _NullSetTrait;
        $this->assertEquals($add, $test->add($add));
    }

    public function test_remove_returns_self()
    {
        $test = new _NullSetTrait;
        $add = new _NullSetTrait;
        $this->assertEquals($test, $test->add($add));
    }

    public function test_contains_returns_false()
    {
        $test = new _NullSetTrait;
        $this->assertFalse($test->contains(TestValueObject::fromNative('test')));
    }

    public function test_to_array_returns_blank_array()
    {
        $set = new _NullSetTrait;

        $test = $set->toArray();

        $this->assertTrue(is_array($test));
        $this->assertEquals(0, count($test));
    }

    public function test_nonNullValues_returns_blank_array()
    {
        $set = new _NullSetTrait;

        $test = $set->toArray();

        $this->assertTrue(is_array($test));
        $this->assertEquals(0, count($test));
    }
}

final class _NullSetTrait implements Set
{
    use NullSetTrait;
}