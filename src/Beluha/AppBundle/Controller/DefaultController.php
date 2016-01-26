<?php

namespace Beluha\AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\VarDumper\VarDumper;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Beluha\AppBundle\EventListener\BeluhaListener;
use Beluha\AppBundle\Event\FilterFooEvent;
use Beluha\AppBundle\Event\FooConstructEvents;

class DefaultController extends Controller
{

    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request, $_controller)
    {


        $dispatcher = $this->get('event_dispatcher');
        $listener   = new BeluhaListener();
        $dispatcher->addListener('foo.construct',
            array($listener, 'onFooAction'));
        $foo        = $this->get('foo');
        $event      = new FilterFooEvent($foo);
        $dispatcher->dispatch(FooConstructEvents::FOO_CONSTRUCT, $event);

        $response = new Response();


        //$user   = $this->getUser();
        //$dumper->dump($user); exit;
        //$response-> setStatusCode(500);
        $user = $this->getDoctrine()->getRepository('BeluhaSecurityBundle:User')->findOneBy(
                ['username' => 'admin']
        );        
        $dumper = new VarDumper();
        $dumper->dump($user);
        //$dumper->dump($foo);
        return $this->render('BeluhaBlogBundle:Default:index.html.twig',
                ['controller' => $_controller], $response);
    }
}