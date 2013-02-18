<?php
namespace Icecave\Evoke;

use PHPUnit_Framework_TestCase;

class ReflectorFactoryTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->_factory = new ReflectorFactory;
    }

    /**
     * @dataProvider callables
     */
    public function testNormalize($callable, $expected)
    {
        $result = $this->_factory->normalize($callable);
        $this->assertSame($expected, $result);
    }

    public function callables()
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
