# ![Evoke]

[![Build Status]](http://travis-ci.org/IcecaveStudios/evoke)
[![Test Coverage]](http://icecave.com.au/evoke/artifacts/tests/coverage)

---

**Evoke** is a small library PHP for invoking callables using a collection of named parameters.

## Installation

Available as [Composer](http://getcomposer.org) package [icecave/evoke](https://packagist.org/packages/icecave/evoke).

<!-- references -->
[Evoke]: http://icecave.com.au/assets/img/project-icons/icon-evoke.png
[Build Status]: https://raw.github.com/IcecaveStudios/evoke/gh-pages/artifacts/images/icecave/regular/build-status.png
[Test Coverage]: https://raw.github.com/IcecaveStudios/evoke/gh-pages/artifacts/images/icecave/regular/coverage.png

## Example

```php
<?php
use Icecave\Evoke;

$invoker = new Invoker;

$func = function ($a, $b = 20, $c) {
    return array($a, $b, $c);
};

$args = array('a' => 10, 'c' => 30);

$result = $invoker->invoke($func, $args);

assert($result === array(10, 20, 30));
```
