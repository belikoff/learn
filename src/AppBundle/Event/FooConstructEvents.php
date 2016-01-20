<?php

namespace AppBundle\Event;

final class FooConstructEvents
{
    /**
     * Событие foo.construct создаётся всякий раз, когда в системе создаётся объект FooService.
     *
     * Слушатель получит экземпляр 
     *
     * @var string
     */    
    const FOO_CONSTRUCT = 'foo.construct';
}