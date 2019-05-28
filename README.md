# Evoke

[![Build Status](http://img.shields.io/travis/icecave/evoke/master.svg?style=flat-square)](https://travis-ci.org/icecave/evoke)
[![Code Coverage](https://img.shields.io/codecov/c/github/icecave/evoke/master.svg?style=flat-square)](https://codecov.io/github/icecave/evoke)
[![Latest Version](http://img.shields.io/packagist/v/icecave/evoke.svg?style=flat-square&label=semver)](https://semver.org)

**Evoke** is a small PHP library for invoking callables using positional and
named parameters, a little like Python's `*args, **kwargs` syntax.

    composer require icecave/evoke

## Example

```php
use Icecave\Evoke\Invoker;

$invoker = new Invoker;

$func = function ($a, $b, $c = 30, $d) {
    return array($a, $b, $c, $d);
};

$positionalArguments = array(10, 20);
$keywordArguments = array('d' => '40');

$result = $invoker->invoke($func, $positionalArguments, $keywordArguments);

assert($result === array(10, 20, 30, 40));
```
