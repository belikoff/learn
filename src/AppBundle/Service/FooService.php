<?php

namespace AppBundle\Service;


use Symfony\Component\VarDumper\VarDumper;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\DependencyInjection\ContainerBuilder;

use AppBundle\Event\FilterFooEvent;
use AppBundle\Event\FooConstructEvents;
use Symfony\Component\EventDispatcher\EventDispatcher;



class FooService
{
    
    
    /*public function __construct ( $name) {

        $name->dump($name);
}*/
    
    /*public function setDumper( $dumper)
    {
        $dumper->dump($dumper);
    }*/
    
    public function __construct(RequestStack $requestStack)
    {

       
        $container = new ContainerBuilder();
        //$dumper = new VarDumper();
        //$dumper->dump($requestStack); 
     
        //$dumper->dump($container->hasDefinition ( 'foo'));
        
    }   
}
