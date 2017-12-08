<?php

// @codingStandardsIgnoreFile

declare(strict_types=1);

namespace Funeralzone\ValueObjects\Scalars;

use Funeralzone\ValueObjects\ValueObject;
use PHPUnit\Framework\TestCase;
use InvalidArgumentException;

final class StringTraitTest extends TestCase
{
    public function test_is_null_returns_false()
    {
        $test = new _StringTrait('');
        $this->assertFalse($test->isNull());
    }

    public function test_is_same_returns_false_when_values_mismatch()
    {
        $test1 = new _StringTrait('test-1');
        $test2 = new _StringTrait('test-2');

        $this->assertFalse($test1->isSame($test2));
    }

    public function test_is_same_returns_true_when_values_match()
    {
        $test1 = new _StringTrait('test-1');
        $test2 = new _StringTrait('test-1');

        $this->assertTrue($test1->isSame($test2));
    }

    public function test_from_native_throws_exception_when_given_non_string()
    {
        $this->expectException(InvalidArgumentException::class);
        _StringTrait::fromNative(1000);

        $this->expectException(InvalidArgumentException::class);
        _StringTrait::fromNative(null);
    }

    public function test_to_native_returns_string()
    {
        $test = new _StringTrait('');
        $this->assertTrue(is_string($test->toNative()));
    }
}

final class _StringTrait implements ValueObject
{
    use StringTrait;
}
