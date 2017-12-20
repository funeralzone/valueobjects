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

## Quick introduction to value objects ##

A value object is a concept in domain driven design (DDD). They are objects whose equality is not dependent on identity.

```php
$location1 = new Location(1.2902, 103.8519);
$location2 = new Location(1.2902, 103.8519);
```

`$location1` and `$location2` are considered equal because they both have the same latitude and longitude. The definition of a `Location` is purely based on its value. If the values change, it's a new location.

```php
$userId = 9302;
$products = [2901, 9303, 0185];

$order1 = new Order($userId, $productIds);
$order2 = new Order($userId, $productIds);
```

These two orders are not identical. Even though they share the same values, they are two different orders. Their identity is not based purely on their value. An `Order` is not a value object.

## Our approach ##

You should not be relying on a library to define your value objects. VOs are just values in your domain. They should be completely specific to your business logic. In an ideal world, they should just be pure PHP objects, written from scratch for each value in your domain.

Practically, that would lead to a lot of boilerplate and copy-pasting to achieve common tasks like comparison and serialisation. So developers go about creating a "value object library" to save time. Typically, the approach is to provide a bunch of generic, reusable value objects. This approach quickly descends into code like this:

```php
public function changeUserEmail(GenericIdObject $id, GenericEmailObject $email);
```

Where did 'GenericIdObject' come from? If that's part of the ubiquitous language of your domain, something's gone seriously wrong with your domain modelling process.

What's happened is arbitrary application language (from your third party VO library) has crept into your domain. Much better would be to conform the naming of your VOs to actual domain language like so:

```php
public function changeUserEmail(UserId $id, Email $email);
```

You can achieve this with typical VO libraries by using inheritance.

```php
class UserId extends GenericIdObject {
...
```

But your VO is still being influenced by the underlying generic VO you're inheriting from. `UserId` is still of the `GenericIdObject` type. It shouldn't be. `UserId` should be a pure type.

Our VO library attempts to solve this issue by taking a different approach. Instead of supplying you with lots of generic VOs you can extend from, we give you the tools to create your own pure VOs from scratch. This is mainly achieved through the use of:

* a small VO interface (it's as tiny as we think it can be whilst still being useful)
* a set of PHP traits you can use to help implement the interface

This is the interface:

```php
interface ValueObject
{
    public function isNull(): bool;
    public function isSame(ValueObject $object): bool;
    public static function fromNative($native);
    public function toNative();
}
```

* `isNull` A simple boolean value of whether the value is null or not.
* `isSame` Whether the value of this `ValueObject` can be considered equivalent to another `ValueObject`
* `fromNative` and `toNative` are essentially for serialisation. For getting your VOs in and out of your application (e.g. persisting and retrieving from a database)

All you have to do to create a new VO is write a class which implements the `ValueObject` interface. You don't extend from anywhere else. You don't have to write large amounts of code to conform to a bloated interface.

Of course, if your domain is dealing with the same types of value over and over again, you don't want to have to keep coding the same logic hundreds of times. So we've provided you with some traits which implement some or all of the interface. You can find them under:

*src/Scalars*

Unfortunately, we've had to diverge from traits to provide more complex functionality. In order to implement sets and nullables (see below) we've had to introduce a couple of abstract classes.

But at no point while using this library will you be able to inherit from some of our code without having to at least write a couple of lines of code to customise the object to your use case. We hope this will lead to better quality value objects, that are more domain specific, with minimal effort.

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
