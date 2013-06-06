# Evoke

[![Build Status]](http://travis-ci.org/IcecaveStudios/evoke)
[![Test Coverage]](http://icecavestudios.github.io/evoke/artifacts/tests/coverage)

**Evoke** is a small PHP library for invoking callables using positional and named parameters, a little like Python's `*args, **kwargs` syntax.

* Install via [Composer](http://getcomposer.org) package [icecave/evoke](https://packagist.org/packages/icecave/evoke)
* Read the [API documentation](http://icecavestudios.github.io/evoke/artifacts/documentation/api/)

## Example

```php
<?php
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

<!-- references -->
[Build Status]: https://raw.github.com/IcecaveStudios/evoke/gh-pages/artifacts/images/icecave/regular/build-status.png
[Test Coverage]: https://raw.github.com/IcecaveStudios/evoke/gh-pages/artifacts/images/icecave/regular/coverage.png
