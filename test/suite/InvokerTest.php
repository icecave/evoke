<?php
namespace Icecave\Evoke;

use PHPUnit_Framework_TestCase;

class InvokerTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->invoker = new Invoker;
    }

    public function testInvoke()
    {
        $func = function ($a, $b, $c) {
            return array($a, $b, $c);
        };

        $arguments = array(
            'c' => 30,
            'a' => 10,
            'b' => 20,
        );

        $result = $this->invoker->invoke($func, array(), $arguments);

        $this->assertSame(array(10, 20, 30), $result);
    }

    public function testInvokeWithDefaults()
    {
        $func = function ($a, $b, $c = 30) {
            return array($a, $b, $c);
        };

        $arguments = array(
            'b' => 20,
            'a' => 10,
        );

        $result = $this->invoker->invoke($func, array(), $arguments);

        $this->assertSame(array(10, 20, 30), $result);
    }

    /**
     * @link https://bugs.php.net/bug.php?id=62715
     */
    public function testInvokeWithNonOptionalDefaults()
    {
        if (version_compare(PHP_VERSION, '5.3.17') < 0) {
            $this->markTestSkipped('PHP bug #62715 prevents detection of default values for non-optional parameters.');
        }

        $func = function ($a, $b = 20, $c) {
            return array($a, $b, $c);
        };

        $arguments = array(
            'c' => 30,
            'a' => 10,
        );

        $result = $this->invoker->invoke($func, array(), $arguments);

        $this->assertSame(array(10, 20, 30), $result);
    }

    public function testInvokeMissingParameterFailure()
    {
        $func = function ($a, $b, $c) {
            return array($a, $b, $c);
        };

        $arguments = array(
            'c' => 30,
            'a' => 10,
        );

        $this->setExpectedException('BadMethodCallException', 'No value provided for required parameter "b".');
        $result = $this->invoker->invoke($func, array(), $arguments);
    }

    public function testInvokeUnknownParameterFailure()
    {
        $func = function ($a) {
            return array($a);
        };

        $arguments = array(
            'a' => 10,
            'b' => 20,
        );

        $this->setExpectedException('BadMethodCallException', 'Unknown parameter "b".');
        $result = $this->invoker->invoke($func, array(), $arguments);
    }

    public function testInvokePositionalArguments()
    {
        $func = function ($a, $b, $c, $d, $e) {
            return array($a, $b, $c, $d, $e);
        };

        $arguments = array(
            'c' => 30,
            'd' => 40,
            'e' => 50,
        );

        $result = $this->invoker->invoke($func, array(10, 20), $arguments);

        $this->assertSame(array(10, 20, 30, 40, 50), $result);
    }

    public function testInvokePositionalArgumentsFailure()
    {
        $func = function ($a) {
            return array($a);
        };

        $this->setExpectedException('BadMethodCallException', 'Too many positional arguments.');
        $result = $this->invoker->invoke($func, array(10, 20), array());
    }

    public function testInvokePositionalArgumentsDuplicateFailure()
    {
        $func = function ($a, $b, $c, $d, $e) {
            return array($a, $b, $c, $d, $e);
        };

        $arguments = array(
            'b' => 20,
            'c' => 30,
            'd' => 40,
            'e' => 50,
        );

        $this->setExpectedException('BadMethodCallException', 'Multiple values provided for parameter "b".');
        $result = $this->invoker->invoke($func, array(10, 20), $arguments);
    }
}
