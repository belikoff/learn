<?php

namespace Beluha\AppBundle\Event;

use Symfony\Component\EventDispatcher\Event;
use Beluha\AppBundle\Service\FooService;

class FilterFooEvent extends Event
{
    protected $foo;

    public function __construct(FooService $foo)
    {
        $this->foo = $foo;
    }

    public function getFoo()
    {
        return $this->foo;
    }
}
