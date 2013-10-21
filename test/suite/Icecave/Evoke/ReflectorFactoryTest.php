<?php
namespace Icecave\Evoke;

use PHPUnit_Framework_TestCase;
use ReflectionFunction;
use ReflectionMethod;

class ReflectorFactoryTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->factory = new ReflectorFactory;
    }

    /**
     * @dataProvider callableReflectors
     */
    public function testCreate($callable, $expected)
    {
        $result = $this->factory->create($callable);
        $this->assertEquals($expected, $result);
    }

    public function callableReflectors()
    {
        $closure = function () { };

        return array(
            'global function'         => array('strlen',                               new ReflectionFunction('strlen')),
            'static method string'    => array('DateTime::createFromFormat',           new ReflectionMethod('DateTime', 'createFromFormat')),
            'static method array'     => array(array('DateTime', 'createFromFormat'),  new ReflectionMethod('DateTime', 'createFromFormat')),
            'method array'            => array(array(new \DateTime, 'getOffset'),      new ReflectionMethod('DateTime', 'getOffset')),
            'callable object'         => array(new TestFixtures\CallableObject,        new ReflectionMethod('Icecave\Evoke\TestFixtures\CallableObject', '__invoke')),
            'closure'                 => array($closure,                               new ReflectionFunction($closure)),
        );
    }

    /**
     * @dataProvider callableNormalizedArrays
     */
    public function testNormalize($callable, $expected)
    {
        $result = $this->factory->normalize($callable);
        $this->assertSame($expected, $result);
    }

    public function callableNormalizedArrays()
    {
        $closure = function () { };

        return array(
            'global function'         => array('strlen',                               array(null, 'strlen')),
            'static method string'    => array('DateTime::createFromFormat',           array('DateTime', 'createFromFormat')),
            'static method array'     => array(array('DateTime', 'createFromFormat'),  array('DateTime', 'createFromFormat')),
            'method array'            => array(array(new \DateTime, 'getOffset'),      array('DateTime', 'getOffset')),
            'callable object'         => array(new TestFixtures\CallableObject,        array('Icecave\Evoke\TestFixtures\CallableObject', '__invoke')),
            'closure'                 => array($closure,                               array(null, $closure)),
        );
    }
}
