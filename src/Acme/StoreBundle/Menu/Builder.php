<?php
namespace Acme\StoreBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

class Builder implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    public function mainMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root');
        $menu->setChildrenAttribute('class', 'nav navbar-nav');

        $menu->addChild('Главная', array('route' => 'homepage'));

        // access services from the container!
        $em = $this->container->get('doctrine')->getManager();
        // findMostRecent and Blog are just imaginary examples
        $authors = $em->getRepository('AcmeStoreBundle:AuthorQuote')->findAll();

        //$menu->addChild('Авторы', array('route' => 'authorquote_index'))->setAttribute('icon', 'fa fa-list')->setAttribute('dropdown', true);
        $menu->addChild('Авторы')->setAttribute('icon', 'fa fa-list')->setAttribute('dropdown', true);
        $menu['Авторы']->addChild('Все авторы',['route' => 'authorquote_index']);
        foreach ($authors as $author){
            $menu['Авторы']->addChild($author->getName(), array(
                'route' => 'authorquote_show',
                'routeParameters' => array('id' => $author->getId())
            ));
        }

        //$menu->addChild('Цитаты', array('route' => 'authorquote_quote_index'));
        $menu->addChild('Цитаты')->setAttribute('icon', 'fa fa-list')->setAttribute('dropdown', true);
        $menu['Цитаты']->addChild('Все цитаты', array('route' => 'authorquote_quote_index'));
        $menu['Цитаты']->addChild('Создать новую', array('route' => 'authorquote_quote_new'));
        // create another menu item
        //$menu->addChild('About Me', array('route' => 'about'));
        // you can also add sub level's to your menu's as follows
        //$menu['About Me']->addChild('Edit profile', array('route' => 'edit_profile'));

        // ... add more children

        return $menu;
    }
}