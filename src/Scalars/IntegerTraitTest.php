<?php

// @codingStandardsIgnoreFile

declare(strict_types=1);

namespace Funeralzone\ValueObjects\Scalars;

use Funeralzone\ValueObjects\ValueObject;
use PHPUnit\Framework\TestCase;
use InvalidArgumentException;

final class IntegerTraitTest extends TestCase
{
    public function test_is_null_returns_false()
    {
        $test = new _IntegerTrait(5);
        $this->assertFalse($test->isNull());
    }

    public function test_is_same_returns_false_when_values_mismatch()
    {
        $test1 = new _IntegerTrait(5);
        $test2 = new _IntegerTrait(6);

        $this->assertFalse($test1->isSame($test2));
    }

    public function test_is_same_returns_true_when_values_match()
    {
        $test1 = new _IntegerTrait(5);
        $test2 = new _IntegerTrait(5);

        $this->assertTrue($test1->isSame($test2));
    }

    public function test_from_native_throws_exception_when_given_non_int()
    {
        $this->expectException(InvalidArgumentException::class);
        _IntegerTrait::fromNative(5.5);

        $this->expectException(InvalidArgumentException::class);
        _IntegerTrait::fromNative('5');

        $this->expectException(InvalidArgumentException::class);
        _IntegerTrait::fromNative(null);
    }

    public function test_to_native_returns_int()
    {
        $test = new _IntegerTrait(5);
        $this->assertTrue(is_int($test->toNative()));
    }
}

final class _IntegerTrait implements ValueObject
{
    use IntegerTrait;
}
