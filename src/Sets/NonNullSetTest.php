<?php

// @codingStandardsIgnoreFile

declare(strict_types=1);

namespace Funeralzone\ValueObjects\Sets;

use Funeralzone\ValueObjects\TestClasses\NonUniqueNonNullSet;
use Funeralzone\ValueObjects\TestClasses\NonNullSetOfNonValueObjects;
use Funeralzone\ValueObjects\TestClasses\TestValueObject;
use Funeralzone\ValueObjects\TestClasses\UniqueNonNullSet;
use Funeralzone\ValueObjects\ValueObject;
use function is_array;
use PHPUnit\Framework\TestCase;
use Exception;

final class NonNullSetTest extends TestCase
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

        $test = new UniqueNonNullSet($values);

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

        $test = new NonUniqueNonNullSet($values);

        $this->assertEquals(5, count($test));
    }

    public function test_outputs_to_array_of_natives()
    {
        $objects = new NonUniqueNonNullSet([
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

        $test = NonUniqueNonNullSet::fromNative($arrayOfStrings);

        $this->assertInstanceOf(NonUniqueNonNullSet::class, $test);
        $this->assertInstanceOf(TestValueObject::class, $test[0]);
        $this->assertInstanceOf(TestValueObject::class, $test[1]);

        /* @var TestValueObject $value0 */
        /* @var TestValueObject $value1 */
        $value0 = $test[0];
        $value1 = $test[1];

        $this->assertEquals('value-1', $value0->toNative());
        $this->assertEquals('value-2', $value1->toNative());
    }

    public function test_can_add_new_values()
    {
        $original = new NonUniqueNonNullSet([
            TestValueObject::fromNative('value-1'),
            TestValueObject::fromNative('value-2'),
        ]);

        $new = $original->add(new NonUniqueNonNullSet([TestValueObject::fromNative('value-3')]));

        $this->assertEquals(3, count($new));
    }

    public function test_can_remove_items_by_value()
    {
        $original = new NonUniqueNonNullSet([
            TestValueObject::fromNative('value-1'),
            TestValueObject::fromNative('value-2'),
            TestValueObject::fromNative('value-3'),
        ]);

        $new = $original->remove(new NonUniqueNonNullSet([
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
        new NonNullSetOfNonValueObjects;
    }

    public function test_is_null_returns_false()
    {
        $test = new NonUniqueNonNullSet([]);
        $this->assertFalse($test->isNull());
    }

    public function test_is_same_returns_true_if_values_are_the_same()
    {
        $test1 = new NonUniqueNonNullSet([
            TestValueObject::fromNative(100),
            TestValueObject::fromNative(200),
        ]);

        $test2 = new NonUniqueNonNullSet([
            TestValueObject::fromNative(200),
            TestValueObject::fromNative(100),
        ]);

        $this->assertTrue($test1->isSame($test2));
    }

    public function test_is_same_returns_false_if_values_differ()
    {
        $test1 = new NonUniqueNonNullSet([
            TestValueObject::fromNative(100),
            TestValueObject::fromNative(200),
        ]);

        $test2 = new NonUniqueNonNullSet([
            TestValueObject::fromNative(200),
            TestValueObject::fromNative(200),
        ]);

        $this->assertFalse($test1->isSame($test2));
    }

    public function test_when_values_are_added_duplicates_are_filtered_if_unique_is_set_to_true()
    {
        $start = new UniqueNonNullSet([
            TestValueObject::fromNative(100),
            TestValueObject::fromNative(200),
        ]);

        $add = new NonUniqueNonNullSet([
            TestValueObject::fromNative(100),
            TestValueObject::fromNative(100),
            TestValueObject::fromNative(300),
            TestValueObject::fromNative(300),
        ]);
        
        $test = $start->add($add);

        $this->assertEquals(3, count($test));

        /* @var ValueObject $value0 */
        /* @var ValueObject $value1 */
        /* @var ValueObject $value2 */
        $value0 = $test[0];
        $value1 = $test[1];
        $value2 = $test[2];

        $this->assertEquals(100, $value0->toNative());
        $this->assertEquals(200, $value1->toNative());
        $this->assertEquals(300, $value2->toNative());
    }

    public function test_contains_returns_true_when_value_exists_in_set()
    {
        $set = new NonUniqueNonNullSet([
            TestValueObject::fromNative(100),
            TestValueObject::fromNative(200),
        ]);

        $this->assertTrue($set->contains(TestValueObject::fromNative(200)));
    }

    public function test_contains_returns_false_when_value_does_not_exist_in_set()
    {
        $set = new NonUniqueNonNullSet([
            TestValueObject::fromNative(100),
            TestValueObject::fromNative(200),
        ]);

        $this->assertFalse($set->contains(TestValueObject::fromNative(300)));
    }

    public function test_to_array_returns_internal_values()
    {
        $set = new NonUniqueNonNullSet([
            TestValueObject::fromNative(100),
            TestValueObject::fromNative(200),
        ]);

        $test = $set->toArray();

        $this->assertTrue(is_array($test));
        $this->assertEquals(2, count($test));
        $this->assertInstanceOf(TestValueObject::class, $test[0]);
    }

    public function test_nonNullValues_only_returns_values_that_do_not_equate_to_null()
    {
        $set = new NonUniqueNonNullSet([
            TestValueObject::fromNative(100),
            TestValueObject::fromNative(null),
            TestValueObject::fromNative(300),
            TestValueObject::fromNative(200),
            TestValueObject::fromNative(null),
        ]);

        $test = $set->nonNullValues();

        $this->assertInstanceOf(NonUniqueNonNullSet::class, $test);
        $this->assertEquals(3, count($test));
        $this->assertEquals(100, $test->toArray()[0]->toNative());
        $this->assertEquals(300, $test->toArray()[1]->toNative());
        $this->assertEquals(200, $test->toArray()[2]->toNative());
    }
}
