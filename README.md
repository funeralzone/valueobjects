# valueobjects #

## Requirements ##

Requires PHP 7.1

## Installation ##

Through Composer, obviously:

```
composer require funeralzone/valueobjects
```

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

Coming soon.

## Composite value objects ##

Coming soon.

## Sets of value objects ##

Coming soon.

## Nulls, NonNulls and Nullables ##

## Enums ##

Coming soon.