<?php

// @codingStandardsIgnoreFile

declare(strict_types=1);

namespace Funeralzone\ValueObjects\Enums;

use Funeralzone\ValueObjects\ValueObject;
use PHPUnit\Framework\TestCase;
use InvalidArgumentException;

final class EnumTraitTest extends TestCase
{
    public function test_construct_throws_error_when_value_is_not_defined_as_a_constant()
    {
        $this->expectException(InvalidArgumentException::class);
        new _EnumTrait(10);
    }

    public function test_is_null_returns_false()
    {
        $test = new _EnumTrait(0);
        $this->assertFalse($test->isNull());
    }

    public function test_is_same_returns_true_if_values_match()
    {
        $test1 = new _EnumTrait(0);
        $test2 = new _EnumTrait(0);

        $this->assertTrue($test1->isSame($test2));
    }

    public function test_is_same_returns_false_if_values_mismatch()
    {
        $test1 = new _EnumTrait(0);
        $test2 = new _EnumTrait(1);

        $this->assertFalse($test1->isSame($test2));
    }

    public function test_from_native_only_accepts_an_int()
    {
        $this->expectException(InvalidArgumentException::class);
        _EnumTrait::fromNative('1');

        $this->expectException(InvalidArgumentException::class);
        _EnumTrait::fromNative(null);
    }

    public function test_to_native_returns_an_int()
    {
        $test = new _EnumTrait(0);
        $this->assertTrue(is_int($test->toNative()));
        $this->assertEquals(0, $test->toNative());
    }

    public function test_magic_static_methods_return_objects_with_correct_value()
    {
        $apple = _EnumTrait::APPLE();
        $banana = _EnumTrait::BANANA();
        $cantaloupe = _EnumTrait::CANTALOUPE();

        $this->assertEquals(0, $apple->toNative());
        $this->assertEquals(1, $banana->toNative());
        $this->assertEquals(2, $cantaloupe->toNative());
    }
}

/**
 * @method static _EnumTrait APPLE()
 * @method static _EnumTrait BANANA()
 * @method static _EnumTrait CANTALOUPE()
 */
final class _EnumTrait implements ValueObject
{
    use EnumTrait;

    public const APPLE = 0;
    public const BANANA = 1;
    public const CANTALOUPE = 2;
}