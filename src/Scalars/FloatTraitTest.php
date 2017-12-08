<?php

// @codingStandardsIgnoreFile

declare(strict_types=1);

namespace Funeralzone\ValueObjects\Scalars;

use Funeralzone\ValueObjects\ValueObject;
use PHPUnit\Framework\TestCase;
use InvalidArgumentException;

final class FloatTraitTest extends TestCase
{
    public function test_is_null_returns_false()
    {
        $test = new _FloatTrait(3.141);
        $this->assertFalse($test->isNull());
    }

    public function test_is_same_returns_false_when_values_mismatch()
    {
        $test1 = new _FloatTrait(3.141);
        $test2 = new _FloatTrait(3.142);

        $this->assertFalse($test1->isSame($test2));
    }

    public function test_is_same_returns_true_when_values_match()
    {
        $test1 = new _FloatTrait(3.141);
        $test2 = new _FloatTrait(3.141);

        $this->assertTrue($test1->isSame($test2));
    }

    public function test_from_native_throws_exception_when_given_non_float()
    {
        $this->expectException(InvalidArgumentException::class);
        _FloatTrait::fromNative('3.141');

        $this->expectException(InvalidArgumentException::class);
        _FloatTrait::fromNative(null);
    }

    public function test_from_native_can_handle_floats()
    {
        $test = _FloatTrait::fromNative(3.141);
        $this->assertEquals(3.141, $test->toNative());
    }

    public function test_from_native_can_handle_ints()
    {
        $test = _FloatTrait::fromNative(3);
        $this->assertEquals(3, $test->toNative());
        $this->assertTrue(is_float($test->toNative()));
    }

    public function test_to_native_returns_float()
    {
        $test = new _FloatTrait(3.141);
        $this->assertTrue(is_float($test->toNative()));
    }
}

final class _FloatTrait implements ValueObject
{
    use FloatTrait;
}
