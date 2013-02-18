<?php
namespace Icecave\Evoke\TypeCheck\Validator\Icecave\Evoke;

class InvokerTypeCheck extends \Icecave\Evoke\TypeCheck\AbstractValidator
{
    public function validateConstruct(array $arguments)
    {
        $argumentCount = \count($arguments);
        if ($argumentCount > 1) {
            throw new \Icecave\Evoke\TypeCheck\Exception\UnexpectedArgumentException(1, $arguments[1]);
        }
    }

    public function invoke(array $arguments)
    {
        $argumentCount = \count($arguments);
        if ($argumentCount < 2) {
            if ($argumentCount < 1) {
                throw new \Icecave\Evoke\TypeCheck\Exception\MissingArgumentException('callable', 0, 'callable');
            }
            throw new \Icecave\Evoke\TypeCheck\Exception\MissingArgumentException('arguments', 1, 'array<string, mixed>');
        } elseif ($argumentCount > 2) {
            throw new \Icecave\Evoke\TypeCheck\Exception\UnexpectedArgumentException(2, $arguments[2]);
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
        $value = $arguments[1];
        $check = function ($value) {
            if (!\is_array($value)) {
                return false;
            }
            foreach ($value as $key => $subValue) {
                if (!\is_string($key)) {
                    return false;
                }
            }
            return true;
        };
        if (!$check($arguments[1])) {
            throw new \Icecave\Evoke\TypeCheck\Exception\UnexpectedArgumentValueException(
                'arguments',
                1,
                $arguments[1],
                'array<string, mixed>'
            );
        }
    }

    public function toPositional(array $arguments)
    {
        $argumentCount = \count($arguments);
        if ($argumentCount < 2) {
            if ($argumentCount < 1) {
                throw new \Icecave\Evoke\TypeCheck\Exception\MissingArgumentException('reflector', 0, 'ReflectionFunctionAbstract');
            }
            throw new \Icecave\Evoke\TypeCheck\Exception\MissingArgumentException('arguments', 1, 'array<string, mixed>');
        } elseif ($argumentCount > 2) {
            throw new \Icecave\Evoke\TypeCheck\Exception\UnexpectedArgumentException(2, $arguments[2]);
        }
        $value = $arguments[1];
        $check = function ($value) {
            if (!\is_array($value)) {
                return false;
            }
            foreach ($value as $key => $subValue) {
                if (!\is_string($key)) {
                    return false;
                }
            }
            return true;
        };
        if (!$check($arguments[1])) {
            throw new \Icecave\Evoke\TypeCheck\Exception\UnexpectedArgumentValueException(
                'arguments',
                1,
                $arguments[1],
                'array<string, mixed>'
            );
        }
    }

}
