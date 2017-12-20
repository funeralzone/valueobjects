<?php

// @codingStandardsIgnoreFile

declare(strict_types=1);

namespace Funeralzone\ValueObjects;

use Funeralzone\ValueObjects\TestClasses\TestValueObject;
use PHPUnit\Framework\TestCase;

final class CompositeTraitTest extends TestCase
{
    public function test_is_null_returns_false()
    {
        $test = new _CompositeTrait(100);
        $this->assertFalse($test->isNull());
    }

    public function test_is_same_returns_true_if_values_are_the_same()
    {
        $test1 = new _CompositeTrait(100);
        $test2 = new _CompositeTrait(100);

        $this->assertTrue($test1->isSame($test2));
    }

    public function test_is_same_returns_false_if_values_differ()
    {
        $test1 = new _CompositeTrait(100);
        $test2 = new _CompositeTrait(200);

        $this->assertFalse($test1->isSame($test2));
    }

    public function test_to_native_returns_private_properties_as_array()
    {
        $expectedArray = [
            'testValue' => 100
        ];

        $test = new _CompositeTrait(100);

        $this->assertEquals($expectedArray, $test->toNative());
    }
}

final class _CompositeTrait implements ValueObject
{
    use CompositeTrait;

    private $testValue = 100;

    public function __construct(int $testValue)
    {
        $this->testValue = TestValueObject::fromNative($testValue);
    }

    public function getTestValue(): TestValueObject
    {
        return $this->testValue;
    }

    public static function fromNative($native)
    {
        throw new \Exception('This is just a test.');
    }
}
