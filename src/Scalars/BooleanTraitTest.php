<?php

// @codingStandardsIgnoreFile

declare(strict_types=1);

namespace Funeralzone\ValueObjects\Scalars;

use Funeralzone\ValueObjects\ValueObject;
use PHPUnit\Framework\TestCase;
use InvalidArgumentException;

final class BooleanTraitTest extends TestCase
{
    public function test_is_null_returns_false()
    {
        $test = new _BooleanTrait(true);
        $this->assertFalse($test->isNull());
    }

    public function test_is_same_returns_false_when_values_mismatch()
    {
        $test1 = new _BooleanTrait(true);
        $test2 = new _BooleanTrait(false);

        $this->assertFalse($test1->isSame($test2));
    }

    public function test_is_same_returns_true_when_values_match()
    {
        $test1 = new _BooleanTrait(false);
        $test2 = new _BooleanTrait(false);

        $this->assertTrue($test1->isSame($test2));
    }

    public function test_from_native_throws_exception_when_given_non_bool()
    {
        $this->expectException(InvalidArgumentException::class);
        _BooleanTrait::fromNative(0);

        $this->expectException(InvalidArgumentException::class);
        _BooleanTrait::fromNative('');

        $this->expectException(InvalidArgumentException::class);
        _BooleanTrait::fromNative(null);
    }

    public function test_to_native_returns_bool()
    {
        $test = new _BooleanTrait(false);
        $this->assertTrue(is_bool($test->toNative()));
    }

    public function test_true_method_returns_true_object()
    {
        $test = _BooleanTrait::true();
        $this->assertTrue($test->toNative());
    }

    public function test_false_method_returns_false_object()
    {
        $test = _BooleanTrait::false();
        $this->assertFalse($test->toNative());
    }

    public function test_is_true_returns_true_when_true()
    {
        $test = _BooleanTrait::true();
        $this->assertTrue($test->isTrue());
    }

    public function test_is_true_returns_false_when_false()
    {
        $test = _BooleanTrait::false();
        $this->assertFalse($test->isTrue());
    }

    public function test_is_false_returns_true_when_false()
    {
        $test = _BooleanTrait::false();
        $this->assertTrue($test->isFalse());
    }

    public function test_is_false_returns_false_when_true()
    {
        $test = _BooleanTrait::true();
        $this->assertFalse($test->isFalse());
    }
}

final class _BooleanTrait implements ValueObject
{
    use BooleanTrait;
}
