<?php

namespace AppBundle\EventListener;

use AppBundle\Event\FilterFooEvent;
use Symfony\Component\VarDumper\VarDumper;

class AcmeListener
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

