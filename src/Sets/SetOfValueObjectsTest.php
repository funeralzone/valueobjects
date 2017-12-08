<?php

// @codingStandardsIgnoreFile

declare(strict_types=1);

namespace Funeralzone\ValueObjects\Sets;

use Funeralzone\ValueObjects\TestClasses\NonUniqueSet;
use Funeralzone\ValueObjects\TestClasses\SetOfNonValueObjects;
use Funeralzone\ValueObjects\TestClasses\TestValueObject;
use Funeralzone\ValueObjects\TestClasses\UniqueSet;
use PHPUnit\Framework\TestCase;
use Exception;

final class SetOfValueObjectsTest extends TestCase
{
    public function test_enforces_unique_when_specified()
    {
        $values = [
            TestValueObject::fromNative('non-unique'),
            TestValueObject::fromNative('value-1'),
            TestValueObject::fromNative('non-unique'),
            TestValueObject::fromNative('value-2'),
            TestValueObject::fromNative('non-unique'),
        ];

        $test = new UniqueSet($values);

        $this->assertEquals(3, count($test));
    }

    public function test_does_not_enforce_unique_when_not_specified()
    {
        $values = [
            TestValueObject::fromNative('non-unique'),
            TestValueObject::fromNative('value-1'),
            TestValueObject::fromNative('non-unique'),
            TestValueObject::fromNative('value-2'),
            TestValueObject::fromNative('non-unique'),
        ];

        $test = new NonUniqueSet($values);

        $this->assertEquals(5, count($test));
    }

    public function test_outputs_to_array_of_natives()
    {
        $objects = new NonUniqueSet([
            TestValueObject::fromNative('value-1'),
            TestValueObject::fromNative('value-2'),
        ]);

        $test = $objects->toNative();

        $this->assertEquals(2, count($test));
        $this->assertTrue(is_string($test[0]));
        $this->assertTrue(is_string($test[1]));
        $this->assertEquals('value-1', $test[0]);
        $this->assertEquals('value-2', $test[1]);
    }

    public function test_can_be_instantiated_from_array_of_natives()
    {
        $arrayOfStrings = [
            'value-1',
            'value-2'
        ];

        $test = NonUniqueSet::fromNative($arrayOfStrings);

        $this->assertInstanceOf(NonUniqueSet::class, $test);
        $this->assertInstanceOf(TestValueObject::class, $test[0]);
        $this->assertInstanceOf(TestValueObject::class, $test[1]);

        /* @var TestValueObject $value0 */
        /* @var TestValueObject $value1 */
        $value0 = $test[0];
        $value1 = $test[1];

        $this->assertEquals('value-1', $value0->toNative());
        $this->assertEquals('value-2', $value1->toNative());
    }

    public function test_can_merge_new_values()
    {
        $original = new NonUniqueSet([
            TestValueObject::fromNative('value-1'),
            TestValueObject::fromNative('value-2'),
        ]);

        $new = $original->add(new NonUniqueSet([TestValueObject::fromNative('value-3')]));

        $this->assertEquals(3, count($new));
    }

    public function test_can_remove_items_by_value()
    {
        $original = new NonUniqueSet([
            TestValueObject::fromNative('value-1'),
            TestValueObject::fromNative('value-2'),
            TestValueObject::fromNative('value-3'),
        ]);

        $new = $original->remove(new NonUniqueSet([
            TestValueObject::fromNative('value-1'),
            TestValueObject::fromNative('value-3'),
        ]));

        /* @var TestValueObject $value */
        $value = $new[0];

        $this->assertEquals(1, count($new));
        $this->assertEquals('value-2', $value->toNative());
    }

    public function test_cannot_create_sets_from_objects_that_are_not_value_object()
    {
        $this->expectException(Exception::class);
        new SetOfNonValueObjects;
    }

    public function test_is_null_returns_false()
    {
        $test = new NonUniqueSet([]);
        $this->assertFalse($test->isNull());
    }

    public function test_is_same_returns_true_if_values_are_the_same()
    {
        $test1 = new NonUniqueSet([
            TestValueObject::fromNative(100),
            TestValueObject::fromNative(200),
        ]);

        $test2 = new NonUniqueSet([
            TestValueObject::fromNative(200),
            TestValueObject::fromNative(100),
        ]);

        $this->assertTrue($test1->isSame($test2));
    }

    public function test_is_same_returns_false_if_values_differ()
    {
        $test1 = new NonUniqueSet([
            TestValueObject::fromNative(100),
            TestValueObject::fromNative(200),
        ]);

        $test2 = new NonUniqueSet([
            TestValueObject::fromNative(200),
            TestValueObject::fromNative(200),
        ]);

        $this->assertFalse($test1->isSame($test2));
    }
}
