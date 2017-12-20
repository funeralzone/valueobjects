# valueobjects #

[![Build Status](https://travis-ci.org/funeralzone/valueobjects.svg)](https://travis-ci.org/funeralzone/valueobjects)
[![Version](https://img.shields.io/packagist/v/funeralzone/valueobjects.svg)](https://packagist.org/packages/funeralzone/valueobjects)

## Requirements ##

Requires PHP 7.1

## Installation ##

Through Composer, obviously:

```
composer require funeralzone/valueobjects
```

## Extensions ##

This library only deals with fundamental values (scalars). We've also released an [extension library](https://github.com/funeralzone/valueobject-extensions) which provides a starting point for more complex values.

## Our approach ##

We've written up our philosophy to PHP value objects in our [A better way of writing value objects in PHP](https://medium.com/funeralzone) article.

## Single value object ##

If your VO encapsulates a single value, it's most likely a scalar. We've provided some traits to deal with scalars under:

*src/Scalars*

Let's say you have a domain value called 'User Email'. You'd create a class which implements the `ValueObject` interface:

```php
final class UserEmail implements ValueObject {
...
```

You now need to implement the interface. But because an email can essentially be considered a special kind of string (in this simple case) the `StringTrait` helper trait can implement most of the interface for you:

```php
final class UserEmail implements ValueObject {

    use StringTrait;
...
```

In our case, a user's email has other domain logic that we can encapsulate in our VO. User emails have to be a valid email:

```php
...
    public function __construct(string $string)
    {
        Assert::that($string)->email();
        $this->string = $string;
    }
...
```

You can see an example of how to implement single value objects in the examples directory.

## Composite value objects ##

A composite value object is a more complex value which is made from other values.

```php
final class Location implements ValueObject
{
    use CompositeTrait;
    
    private $latitude;
    private $longitude;
    
    public function __construct(Latitude $latitude, Longitude $longitude)
    {
        $this->latitude = $latitude;
        $this->longitude = $longitude;
    }
    
    public function getLatitude(): Latitude
    {
        return $this->latitude;
    }
    
    public function getLongitude(): Longitude
    {
        return $this->longitude;
    }
...
```

A `Location` is made up of two VOs (latitude, longitude). We've provided a `CompositeTrait` to easily implement most of the `ValueObject` interface automatically. It handles `toNative` serialistation by using reflection to return an array of all the class properties.

The `CompositeTrait` does not implement `fromNative`. We leave the construction of your object up to you.

```php
...
    public static function fromNative($native)
    {
        return new static(
            Latitude::fromNative($native['latitude']),
            Longitude::fromNative($native['longitude'])
        );
    }
...
```

You can see an example of how to implement composite objects in the examples directory.

## Sets of value objects ##

A set of value objects can be represented by leveraging the `SetOfValueObjects` abstract class.

```php
final class SetOfLocations extends SetOfValueObjects implements ValueObject
{
    protected function typeToEnforce(): string
    {
        return Location::class;
    }

    public static function valuesShouldBeUnique(): bool
    {
        return true;
    }
}
```

A set of value objects is itself a `ValueObject` and implements all of the standard methods.

There are two abstract methods that need to be implemented.

* `typeToEnforce` should return a string of the class name of the value object that you want to make a set of.
* `valuesShouldBeUnique` should return a boolean representing whether you want to force the set to be unique.

If the set is set to unique, if duplicate values are added to the set (at instantiation or through the `add` method) the duplicates are filtered out.

### Usage of a set ###

A set extends from PHP's [ArrayObject](http://php.net/manual/en/class.arrayobject.php) which means they can be used like standard arrays.

```php
$set = new SetOfValueObjects([$one, $two]);
foreach($set as $value) {
    // TODO: Do something with each value object
}
```

Sets also have two additional useful methods:

#### add ####

Merges another set.

```php
$set = new SetOfValueObjects([$one, $two]);
$anotherSet = new SetOfValueObjects([$three]);
$mergedSet = $set->add($anotherSet);
count($mergedSet) // Equals: 3
```

#### remove ####

Removes values from a set by using another set as reference values.

```php
$set = new SetOfValueObjects([$one, $two, $three]);
$anotherSet = new SetOfValueObjects([$one]);
$remove = $set->remove($anotherSet);
count($remove) // Equals: 2
```

## Nulls, NonNulls and Nullables ##

This package allows you to deal with nullable value objects.

First create a type of value object.

```php
interface PhoneNumber extends ValueObject
{
}
```

Implement a non-null version of the value object.

```php
final class NonNullPhoneNumber implements PhoneNumber
{
    use StringTrait;
}
```

Implement a null version of the value object.

```php
final class NullPhoneNumber implements PhoneNumber
{
    use NullTrait;
}
```

Implement a nullable version of the value object.

```php
final class NullablePhoneNumber extends Nullable implements PhoneNumber
{
    protected static function nonNullImplementation(): string
    {
        return NonNullPhoneNumber::class;
    }
    
    protected static function nullImplementation(): string
    {
        return NullPhoneNumber::class;
    }
}
```

This 'nullable' handles automatic creation of either a null or a non-null version of the interface based on the native input. For example:

```php
$phoneNumber = NullablePhoneNumber::fromNative(null);
```

The `$phoneNumber` above will automatically use the `NullPhoneNumber` implementation specified above.

Or:

```php
$phoneNumber = NullablePhoneNumber::fromNative('+44 73715525763');
```

The `$phoneNumber` above will automatically use the `NonNullPhoneNumber` implementation specified above.

## Enums ##

Enums can be defined easily through use of the `EnumTrait`. Then, the enum values are simply listed as constants on the class.

```php
final class Fastening implements ValueObject
{
    use EnumTrait;
    
    public const BUTTON = 0;
    public const CLIP = 1;
    public const PIN = 2;
    public const ZIP = 3;
}
```

When dealing with value object serialisation, the constant values (not names) are used. So:

```php
$fastening = Fastening::fromNative(2);
$fastening->toNative(); // Equals 2
```

In code, the trait utilises magic methods to create objects based on constant name like so:

```php
$fastening = Fastening::ZIP();
$fastening->toNative(); // Equals 3
```

If your IDE supports code completion and you'd like to use named methods to create enums you can add the following PHPDoc block to your enum class:

```php
/**
 * @method static Fastening BUTTON()
 * @method static Fastening CLIP()
 * @method static Fastening PIN()
 * @method static Fastening ZIP()
 */
final class Fastening implements ValueObject
```
