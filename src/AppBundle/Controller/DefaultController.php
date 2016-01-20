<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\VarDumper\VarDumper;
use Symfony\Component\EventDispatcher\EventDispatcher;
use AppBundle\EventListener\AcmeListener;
use AppBundle\Event\FilterFooEvent;
use AppBundle\Event\FooConstructEvents;

class DefaultController extends Controller
{

    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request, $_controller)
    {


        $dispatcher = $this->get('event_dispatcher');
        $listener   = new AcmeListener();
        $dispatcher->addListener('foo.construct',
            array($listener, 'onFooAction'));
        $foo        = $this->get('foo');
        $event      = new FilterFooEvent($foo);
        $dispatcher->dispatch(FooConstructEvents::FOO_CONSTRUCT, $event);

        $response = new Response();


        $user   = $this->getUser();
        //$dumper->dump($user); exit;
        //$response-> setStatusCode(500);
        $dumper = new VarDumper();
        //$dumper->dump($dispatcher);
        //$dumper->dump($foo);
        return $this->render('AcmeStoreBundle:Default:index.html.twig',
                ['controller' => $_controller], $response);
    }
}