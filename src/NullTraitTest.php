<?php

// @codingStandardsIgnoreFile

declare(strict_types=1);

namespace Funeralzone\ValueObjects;

use PHPUnit\Framework\TestCase;

final class NullTraitTest extends TestCase
{
    public function test_is_null_returns_true()
    {
        $test = new _NullTrait;
        $this->assertTrue($test->isNull());
    }

    public function test_is_same_returns_true_when_native_is_null()
    {
        $test1 = new _NullTrait;
        $test2 = new _NullTrait;
        $this->assertTrue($test1->isSame($test2));
    }

    public function test_is_same_returns_false_when_native_is_not_null()
    {
        $test1 = new _NullTrait;
        $test2 = new _NonNull;
        $this->assertFalse($test1->isSame($test2));
    }

    public function test_from_native_disregards_value()
    {
        $test1 = _NullTrait::fromNative('test');
        $test2 = _NullTrait::fromNative(null);
        $test3 = _NullTrait::fromNative(5);

        $this->assertInstanceOf(_NullTrait::class, $test1);
        $this->assertInstanceOf(_NullTrait::class, $test2);
        $this->assertInstanceOf(_NullTrait::class, $test3);
    }

    public function test_to_native_returns_null()
    {
        $test1 = _NullTrait::fromNative('test');
        $test2 = _NullTrait::fromNative(null);
        $test3 = _NullTrait::fromNative(5);

        $this->assertNull($test1->toNative());
        $this->assertNull($test2->toNative());
        $this->assertNull($test3->toNative());
    }
}

final class _NullTrait implements ValueObject
{
    use NullTrait;
}

final class _NonNull implements ValueObject
{
    use NullTrait;

    public function toNative()
    {
        return 'test';
    }
}