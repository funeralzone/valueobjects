<?php

// @codingStandardsIgnoreFile

declare(strict_types=1);

namespace Funeralzone\ValueObjects;

use PHPUnit\Framework\TestCase;
use Mockery;

final class NullableTest extends TestCase
{
    public function test_is_null_proxies_to_wrapped_value_object()
    {
        $mockValueObject1 = Mockery::mock(ValueObject::class);
        $mockValueObject1->shouldReceive('isNull')
            ->andReturn(true);
        $mockValueObject2 = Mockery::mock(ValueObject::class);
        $mockValueObject2->shouldReceive('isNull')
            ->andReturn(false);

        $test1 = new _Nullable($mockValueObject1);
        $test2 = new _Nullable($mockValueObject2);

        $this->assertTrue($test1->isNull());
        $this->assertFalse($test2->isNull());
    }

    public function test_is_same_proxies_to_wrapped_value_object()
    {
        $mockValueObject1 = Mockery::mock(ValueObject::class);
        $mockValueObject1->shouldReceive('isSame')
            ->andReturn(true);
        $mockValueObject2 = Mockery::mock(ValueObject::class);
        $mockValueObject2->shouldReceive('isSame')
            ->andReturn(false);

        $test1 = new _Nullable($mockValueObject1);
        $test2 = new _Nullable($mockValueObject2);

        $this->assertTrue($test1->isSame($test1));
        $this->assertFalse($test2->isSame($test2));
    }

    public function test_to_native_proxies_to_wrapped_value_object()
    {
        $mockValueObject1 = Mockery::mock(ValueObject::class);
        $mockValueObject1->shouldReceive('toNative')
            ->andReturn('returnValue');
        $mockValueObject2 = Mockery::mock(ValueObject::class);
        $mockValueObject2->shouldReceive('toNative')
            ->andReturn(5000);

        $test1 = new _Nullable($mockValueObject1);
        $test2 = new _Nullable($mockValueObject2);

        $this->assertEquals('returnValue', $test1->toNative());
        $this->assertEquals(5000, $test2->toNative());
    }

    public function test_from_native_creates_a_null_object_when_receiving_null()
    {
        $test = _Nullable::fromNative(null);
        $this->assertEquals('null-implementation', $test->toNative());
    }

    public function test_from_native_creates_a_non_null_object_when_receiving_non_null()
    {
        $test = _Nullable::fromNative('');
        $this->assertEquals('non-null-implementation', $test->toNative());
    }

    public function test_null_creates_a_nullable_backed_by_the_null_implementation()
    {
        $test = _Nullable::null();
        $this->assertEquals('null-implementation', $test->toNative());
    }

    public function tearDown(): void
    {
        Mockery::close();
    }
}

interface TestObject extends ValueObject
{
}

final class _Nullable extends Nullable implements TestObject
{
    protected static function nonNullImplementation(): string
    {
        return _NonNullImplementation::class;
    }

    protected static function nullImplementation(): string
    {
        return _NullImplementation::class;
    }
}

final class _NullImplementation implements TestObject
{
    public function isNull(): bool
    {
        throw new \Exception('This is just a test.');
    }

    public function isSame(ValueObject $object): bool
    {
        throw new \Exception('This is just a test.');
    }

    public static function fromNative($native)
    {
        return new self;
    }

    public function toNative()
    {
        return 'null-implementation';
    }
}

final class _NonNullImplementation implements TestObject
{
    public function isNull(): bool
    {
        throw new \Exception('This is just a test.');
    }

    public function isSame(ValueObject $object): bool
    {
        throw new \Exception('This is just a test.');
    }

    public static function fromNative($native)
    {
        return new self;
    }

    public function toNative()
    {
        return 'non-null-implementation';
    }
}
