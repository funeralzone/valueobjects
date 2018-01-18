<?php

// @codingStandardsIgnoreFile

declare(strict_types=1);

namespace Funeralzone\ValueObjects\Sets;

use Funeralzone\ValueObjects\Set;
use PHPUnit\Framework\TestCase;
use Mockery;

final class NullableSetTest extends TestCase
{
    public function test_offsetGet_gets_proxied()
    {
        $mockValueObject1 = Mockery::mock(Set::class);
        $mockValueObject1->shouldReceive('offsetGet')
            ->andReturn(true);
        $mockValueObject2 = Mockery::mock(Set::class);
        $mockValueObject2->shouldReceive('offsetGet')
            ->andReturn(false);

        $test1 = new _NullableSet($mockValueObject1);
        $test2 = new _NullableSet($mockValueObject2);

        $this->assertTrue($test1->offsetGet('test'));
        $this->assertFalse($test2->offsetGet('test'));
    }

    public function test_offsetUnset_get_proxied()
    {
        $mockValueObject1 = Mockery::mock(Set::class);
        $mockValueObject1->shouldReceive('offsetUnset')
            ->once();
        $mockValueObject2 = Mockery::mock(Set::class);
        $mockValueObject2->shouldReceive('offsetUnset')
            ->once();

        $test1 = new _NullableSet($mockValueObject1);
        $test2 = new _NullableSet($mockValueObject2);

        $test1->offsetUnset('test');
        $test2->offsetUnset('test');

        $this->assertTrue(true);
    }

    public function test_count_gets_proxied()
    {
        $mockValueObject1 = Mockery::mock(Set::class);
        $mockValueObject1->shouldReceive('count')
            ->andReturn(100);
        $mockValueObject2 = Mockery::mock(Set::class);
        $mockValueObject2->shouldReceive('count')
            ->andReturn(200);

        $test1 = new _NullableSet($mockValueObject1);
        $test2 = new _NullableSet($mockValueObject2);

        $this->assertEquals(100, $test1->count());
        $this->assertEquals(200, $test2->count());
    }

    public function test_offsetExists_gets_proxied()
    {
        $mockValueObject1 = Mockery::mock(Set::class);
        $mockValueObject1->shouldReceive('offsetExists')
            ->andReturn(true);
        $mockValueObject2 = Mockery::mock(Set::class);
        $mockValueObject2->shouldReceive('offsetExists')
            ->andReturn(false);

        $test1 = new _NullableSet($mockValueObject1);
        $test2 = new _NullableSet($mockValueObject2);

        $this->assertTrue($test1->offsetExists('test'));
        $this->assertFalse($test2->offsetExists('test'));
    }

    public function test_offsetSet_gets_proxied()
    {
        $mockValueObject1 = Mockery::mock(Set::class);
        $mockValueObject1->shouldReceive('offsetSet')
            ->once();
        $mockValueObject2 = Mockery::mock(Set::class);
        $mockValueObject2->shouldReceive('offsetSet')
            ->once();

        $test1 = new _NullableSet($mockValueObject1);
        $test2 = new _NullableSet($mockValueObject2);

        $test1->offsetSet('test', true);
        $test2->offsetSet('test', true);

        $this->assertTrue(true);
    }

    public function test_getIterator_gets_proxied()
    {
        $mockValueObject1 = Mockery::mock(Set::class);
        $mockValueObject1->shouldReceive('getIterator')
            ->andReturn(true);
        $mockValueObject2 = Mockery::mock(Set::class);
        $mockValueObject2->shouldReceive('getIterator')
            ->andReturn(false);

        $test1 = new _NullableSet($mockValueObject1);
        $test2 = new _NullableSet($mockValueObject2);

        $this->assertTrue($test1->getIterator());
        $this->assertFalse($test2->getIterator());
    }

    public function test_add_gets_proxied()
    {
        $mockValueObject1 = Mockery::mock(Set::class);
        $mockValueObject1->shouldReceive('add')
            ->andReturn(true);
        $mockValueObject2 = Mockery::mock(Set::class);
        $mockValueObject2->shouldReceive('add')
            ->andReturn(false);

        $test1 = new _NullableSet($mockValueObject1);
        $test2 = new _NullableSet($mockValueObject2);

        $this->assertTrue($test1->add($test1));
        $this->assertFalse($test2->add($test2));
    }

    public function test_remove_gets_proxied()
    {
        $mockValueObject1 = Mockery::mock(Set::class);
        $mockValueObject1->shouldReceive('remove')
            ->andReturn(true);
        $mockValueObject2 = Mockery::mock(Set::class);
        $mockValueObject2->shouldReceive('remove')
            ->andReturn(false);

        $test1 = new _NullableSet($mockValueObject1);
        $test2 = new _NullableSet($mockValueObject2);

        $this->assertTrue($test1->remove($test1));
        $this->assertFalse($test2->remove($test2));
    }

    public function test_contains_gets_proxied()
    {
        $mockValueObject1 = Mockery::mock(Set::class);
        $mockValueObject1->shouldReceive('contains')
            ->andReturn(true);
        $mockValueObject2 = Mockery::mock(Set::class);
        $mockValueObject2->shouldReceive('contains')
            ->andReturn(false);

        $test1 = new _NullableSet($mockValueObject1);
        $test2 = new _NullableSet($mockValueObject2);

        $this->assertTrue($test1->contains($test1));
        $this->assertFalse($test2->contains($test2));
    }

    public function tearDown()
    {
        Mockery::close();
    }
}

interface TestObject extends Set
{
}

final class _NullableSet extends NullableSet implements TestObject
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
    use NullSetTrait;
}

final class _NonNullImplementation extends NonNullSet implements TestObject
{
    protected function typeToEnforce(): string
    {
        throw new \Exception('This is just a test.');
    }

    public static function valuesShouldBeUnique(): bool
    {
        throw new \Exception('This is just a test.');
    }
}
