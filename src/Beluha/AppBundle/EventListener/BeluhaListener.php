<?php

namespace Beluha\AppBundle\EventListener;

use Beluha\AppBundle\Event\FilterFooEvent;
use Symfony\Component\VarDumper\VarDumper;

class BeluhaListener
{
    public function onFooAction(FilterFooEvent $event)
    {
        $foo = $event->getFoo();
        //$request = 
        $dumper = new VarDumper();
        $messageObject = new \StdClass();
        $messageObject->message = 'events work\'s';
        $dumper->dump($messageObject);
        //exit('events work!');
    }      
}

