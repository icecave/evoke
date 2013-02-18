<?php
namespace Icecave\Evoke\TestFixtures;

class CallableObject
{
    public function __invoke($a, $b, $c = null)
    {
        return array($a, $b, $c);
    }
}
