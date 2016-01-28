<?php

namespace Beluha\BlogBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerInterface as Container;
use Symfony\Component\VarDumper\VarDumper;

/**
 * Description of LoginMenuBuilder
 *
 * @author belikov
 */
class LoginMenuBuilder
{

    private $factory;
    private $container;

    /**
     * @param FactoryInterface $factory
     *
     * Add any other dependency you need
     */
    public function __construct(FactoryInterface $factory, Container $container)
    {
        $this->factory = $factory;
        $this->container = $container;
    }

    public function createMainMenu(array $options)
    {
        /*$menu = $this->factory->createItem('root');
        $menu->setChildrenAttribute('class', 'nav navbar-nav');
        //$dumper = new VarDumper();
        //$dumper->dump($this->container->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY'));

        if ($this->container->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            $menu->addChild('user_form.logout', array('route' => 'logout'))->setExtra('translation_domain', 'security');
        } else {
            $menu->addChild('login', array('route' => 'login'))->setExtra('translation_domain', 'blog');
            $menu->addChild('user_form.registration', array('route' => 'registration'))->setExtra('translation_domain', 'security');
        }
        return $menu;*/
    }
}
