<?php

namespace Acme\StoreBundle\Menu;

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
        $menu = $this->factory->createItem('root');
        $menu->setChildrenAttribute('class', 'nav navbar-nav');
        //$dumper = new VarDumper();
        //$dumper->dump($this->container->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY'));

        if ($this->container->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            $menu->addChild('Выход', array('route' => 'logout'));
        } else {
            $menu->addChild('Вход', array('route' => 'login'));
            $menu->addChild('Регистрация', array('route' => 'registration'));
        }
        return $menu;
    }
}
