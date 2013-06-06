<?php
namespace Icecave\Evoke\TypeCheck\Validator\Icecave\Evoke;

class ReflectorFactoryTypeCheck extends \Icecave\Evoke\TypeCheck\AbstractValidator
{
    public function validateConstruct(array $arguments)
    {
        if (\count($arguments) > 0) {
            throw new \Icecave\Evoke\TypeCheck\Exception\UnexpectedArgumentException(0, $arguments[0]);
        }
    }

    public function create(array $arguments)
    {
        $argumentCount = \count($arguments);
        if ($argumentCount < 1) {
            throw new \Icecave\Evoke\TypeCheck\Exception\MissingArgumentException('callable', 0, 'callable');
        } elseif ($argumentCount > 1) {
            throw new \Icecave\Evoke\TypeCheck\Exception\UnexpectedArgumentException(1, $arguments[1]);
        }
        $value = $arguments[0];
        if (!\is_callable($value)) {
            throw new \Icecave\Evoke\TypeCheck\Exception\UnexpectedArgumentValueException(
                'callable',
                0,
                $arguments[0],
                'callable'
            );
        }
    }

    public function normalize(array $arguments)
    {
        $argumentCount = \count($arguments);
        if ($argumentCount < 1) {
            throw new \Icecave\Evoke\TypeCheck\Exception\MissingArgumentException('callable', 0, 'callable');
        } elseif ($argumentCount > 1) {
            throw new \Icecave\Evoke\TypeCheck\Exception\UnexpectedArgumentException(1, $arguments[1]);
        }
        $value = $arguments[0];
        if (!\is_callable($value)) {
            throw new \Icecave\Evoke\TypeCheck\Exception\UnexpectedArgumentValueException(
                'callable',
                0,
                $arguments[0],
                'callable'
            );
        }
    }

}
