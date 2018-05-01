<?php

// @codingStandardsIgnoreFile

declare(strict_types=1);

namespace Funeralzone\ValueObjects;

use Funeralzone\ValueObjects\TestClasses\NullValue;
use Funeralzone\ValueObjects\TestClasses\TestValueObject;
use PHPUnit\Framework\TestCase;

final class CompositeTraitTest extends TestCase
{
    private function composite(): _CompositeTrait
    {
        return new _CompositeTrait(
            new TestValueObject('A'),
            new TestValueObject('B')
        );
    }

    public function test_is_null_returns_false_when_not_all_sub_values_are_null()
    {
        $test = new _CompositeTrait(
            new TestValueObject(null),
            new TestValueObject('A')
        );
        $this->assertFalse($test->isNull());

        $test = new _CompositeTrait(
            new TestValueObject(null),
            new TestValueObject(false)
        );
        $this->assertFalse($test->isNull());
    }

    public function test_is_null_returns_true_when_all_sub_values_are_null()
    {
        $test = new _CompositeTrait(
            new TestValueObject(null),
            new TestValueObject(null)
        );
        $this->assertTrue($test->isNull());
    }

    public function test_is_same_returns_true_if_values_are_the_same()
    {
        $test1 = $this->composite();
        $test2 = $this->composite();

        $this->assertTrue($test1->isSame($test2));
    }

    public function test_is_same_returns_false_if_values_differ()
    {
        $test1 = new _CompositeTrait(
            new TestValueObject('A'),
            new TestValueObject('B')
        );
        $test2 = new _CompositeTrait(
            new TestValueObject('A'),
            new TestValueObject('C')
        );

        $this->assertFalse($test1->isSame($test2));
    }

    public function test_to_native_returns_private_properties_as_array()
    {
        $expectedArray = [
            'a' => 'A',
            'b' => 'B'
        ];

        $test = $this->composite();

        $this->assertEquals($expectedArray, $test->toNative());
    }
}

final class _CompositeTrait implements ValueObject
{
    use CompositeTrait;

    private $a;
    private $b;

    public function __construct(ValueObject $a, ValueObject $b)
    {
        $this->a = $a;
        $this->b = $b;
    }

    public function getA(): ValueObject
    {
        return $this->a;
    }

    public function getB(): ValueObject
    {
        return $this->b;
    }

    public static function fromNative($native)
    {
        throw new \Exception('This is just a test.');
    }
}
