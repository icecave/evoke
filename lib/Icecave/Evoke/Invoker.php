<?php
namespace Icecave\Evoke;

use BadMethodCallException;
use Icecave\Evoke\TypeCheck\TypeCheck;
use ReflectionFunctionAbstract;

/**
 * Invoke a callable using an array mapping parameter name to argument value.
 */
class Invoker
{
    /**
     * @param ReflectorFactory|null $reflectorFactory
     */
    public function __construct(ReflectorFactory $reflectorFactory = null)
    {
        $this->typeCheck = TypeCheck::get(__CLASS__, func_get_args());

        if (null === $reflectorFactory) {
            $reflectorFactory = new ReflectorFactory;
        }

        $this->reflectorFactory = $reflectorFactory;
    }

    /**
     * Invoke a callable using a map of parameter name to argument value.
     *
     * @param callable             $callable  The callable to invoke.
     * @param array<string, mixed> $arguments An array mapping parameter name to argument value.
     *
     * @return mixed The return value of $callable.
     */
    public function invoke($callable, array $arguments)
    {
        $this->typeCheck->invoke(func_get_args());

        $reflector = $this->reflectorFactory->create($callable);
        $arguments = $this->toPositional($reflector, $arguments);

        return call_user_func_array($callable, $arguments);
    }

    /**
     * Arrange a map of parameter name to argument value into an array of positional argument values.
     *
     * @param ReflectionFunctionAbstract $reflector
     * @param array<string, mixed>       $arguments
     *
     * @return array<integer, mixed>
     */
    public function toPositional(ReflectionFunctionAbstract $reflector, array $arguments)
    {
        $this->typeCheck->toPositional(func_get_args());

        $args = array();

        foreach ($reflector->getParameters() as $parameter) {
            $name = $parameter->getName();
            if (array_key_exists($name, $arguments)) {
                $args[] = $arguments[$name];
            } elseif ($parameter->isDefaultValueAvailable()) {
                $args[] = $parameter->getDefaultValue();
            } else {
                throw new BadMethodCallException('No value provided for required parameter "' . $name . '".');
            }
        }

        return $args;
    }

    private $typeCheck;
    private $reflectorFactory;
}
