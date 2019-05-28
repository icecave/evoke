<?php
namespace Icecave\Evoke;

use BadMethodCallException;
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
        if (null === $reflectorFactory) {
            $reflectorFactory = new ReflectorFactory();
        }

        $this->reflectorFactory = $reflectorFactory;
    }

    /**
     * Invoke a callable using a map of parameter name to argument value.
     *
     * @param callable             $callable   The callable to invoke.
     * @param array<mixed>         $positional Positional arguments.
     * @param array<string, mixed> $keyword    Named keywoard arguments.
     *
     * @return mixed The return value of $callable.
     */
    public function invoke($callable, array $positional, array $keyword)
    {
        $reflector = $this->reflectorFactory->create($callable);
        $arguments = $this->resolveArguments($reflector, $positional, $keyword);

        return call_user_func_array($callable, $arguments);
    }

    /**
     * Arrange a map of parameter name to argument value into an array of positional argument values.
     *
     * @param ReflectionFunctionAbstract $reflector
     * @param array<mixed>               $positional Positional arguments.
     * @param array<string, mixed>       $keyword    Named keywoard arguments.
     *
     * @return array<integer, mixed>
     */
    protected function resolveArguments(ReflectionFunctionAbstract $reflector, array $positional, array $keyword)
    {
        $resolved = array();
        $arguments = array();

        foreach ($reflector->getParameters() as $parameter) {
            $name = $parameter->getName();

            if ($positional) {
                $arguments[] = array_shift($positional);
            } elseif (array_key_exists($name, $keyword)) {
                $arguments[] = $keyword[$name];
                unset($keyword[$name]);
            } elseif ($parameter->isDefaultValueAvailable()) {
                $arguments[] = $parameter->getDefaultValue();
            } else {
                throw new BadMethodCallException('No value provided for required parameter "' . $name . '".');
            }

            $resolved[$name] = true;
        }

        $name = key($keyword);
        if (array_key_exists($name, $resolved)) {
            throw new BadMethodCallException('Multiple values provided for parameter "' . $name . '".');
        } elseif ($name) {
            throw new BadMethodCallException('Unknown parameter "' . $name . '".');
        } elseif ($positional) {
            throw new BadMethodCallException('Too many positional arguments.');
        }

        return $arguments;
    }

    private $reflectorFactory;
}
