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
        if ($argumentCount < 3) {
            if ($argumentCount < 1) {
                throw new \Icecave\Evoke\TypeCheck\Exception\MissingArgumentException('callable', 0, 'callable');
            }
            if ($argumentCount < 2) {
                throw new \Icecave\Evoke\TypeCheck\Exception\MissingArgumentException('positional', 1, 'array');
            }
            throw new \Icecave\Evoke\TypeCheck\Exception\MissingArgumentException('keyword', 2, 'array<string, mixed>');
        } elseif ($argumentCount > 3) {
            throw new \Icecave\Evoke\TypeCheck\Exception\UnexpectedArgumentException(3, $arguments[3]);
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
        $value = $arguments[2];
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
        if (!$check($arguments[2])) {
            throw new \Icecave\Evoke\TypeCheck\Exception\UnexpectedArgumentValueException(
                'keyword',
                2,
                $arguments[2],
                'array<string, mixed>'
            );
        }
    }

    public function resolveArguments(array $arguments)
    {
        $argumentCount = \count($arguments);
        if ($argumentCount < 3) {
            if ($argumentCount < 1) {
                throw new \Icecave\Evoke\TypeCheck\Exception\MissingArgumentException('reflector', 0, 'ReflectionFunctionAbstract');
            }
            if ($argumentCount < 2) {
                throw new \Icecave\Evoke\TypeCheck\Exception\MissingArgumentException('positional', 1, 'array');
            }
            throw new \Icecave\Evoke\TypeCheck\Exception\MissingArgumentException('keyword', 2, 'array<string, mixed>');
        } elseif ($argumentCount > 3) {
            throw new \Icecave\Evoke\TypeCheck\Exception\UnexpectedArgumentException(3, $arguments[3]);
        }
        $value = $arguments[2];
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
        if (!$check($arguments[2])) {
            throw new \Icecave\Evoke\TypeCheck\Exception\UnexpectedArgumentValueException(
                'keyword',
                2,
                $arguments[2],
                'array<string, mixed>'
            );
        }
    }

}
