<?php
namespace Icecave\Evoke;

use PHPUnit_Framework_TestCase;

class InvokerTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->_invoker = new Invoker;
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

        $result = $this->_invoker->invoke($func, $arguments);

        $this->assertSame(array(10, 20, 30), $result);
    }

    public function testInvokeWithDefaults()
    {
        $func = function ($a, $b = 20, $c) {
            return array($a, $b, $c);
        };

        $arguments = array(
            'c' => 30,
            'a' => 10,
        );

        $result = $this->_invoker->invoke($func, $arguments);

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
        $result = $this->_invoker->invoke($func, $arguments);

        $this->assertSame(array(10, 20, 30), $result);
    }
}
