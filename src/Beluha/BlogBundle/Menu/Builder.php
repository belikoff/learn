<?php
namespace Beluha\BlogBundle\Menu;

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

        $menu->addChild('homepage', array('route' => 'homepage'))->setExtra('translation_domain', 'blog');
        $em = $this->container->get('doctrine')->getManager();
        $posts = $em->getRepository('BeluhaBlogBundle:Post')->findAll();
        $menu->addChild('posts')->setAttribute('icon', 'fa fa-list')->setAttribute('dropdown', true)->setExtra('translation_domain', 'blog');
        foreach ($posts as $post){
            $menu['posts']->addChild($post->getTitle(), array(
                'route' => 'beluha_blog_post_show',
                'routeParameters' => array('slug' => $post->getSlug())
            ));
        }
        
        #$em = $this->container->get('doctrine')->getManager();
        // findMostRecent and Blog are just imaginary examples
        #$authors = $em->getRepository('BeluhaBlogBundle:AuthorQuote')->findAll();

        //$menu->addChild('Авторы', array('route' => 'authorquote_index'))->setAttribute('icon', 'fa fa-list')->setAttribute('dropdown', true);
        #$menu->addChild('authors')->setAttribute('icon', 'fa fa-list')->setAttribute('dropdown', true)->setExtra('translation_domain', 'blog');
        #$menu['authors']->addChild('all_authors',['route' => 'authorquote_index'])->setExtra('translation_domain', 'blog');
        /*foreach ($authors as $author){
            $menu['authors']->addChild($author->getName(), array(
                'route' => 'authorquote_show',
                'routeParameters' => array('id' => $author->getId())
            ));
        }*/

        //$menu->addChild('Цитаты', array('route' => 'authorquote_quote_index'));
        #$menu->addChild('quotes')->setAttribute('icon', 'fa fa-list')->setAttribute('dropdown', true)->setExtra('translation_domain', 'blog');
        #$menu['quotes']->addChild('all_quotes', array('route' => 'authorquote_quote_index'))->setExtra('translation_domain', 'blog');
        #$menu['quotes']->addChild('create_new_quote', array('route' => 'authorquote_quote_new'))->setExtra('translation_domain', 'blog');
        // create another menu item
        //$menu->addChild('About Me', array('route' => 'about'));
        // you can also add sub level's to your menu's as follows
        //$menu['About Me']->addChild('Edit profile', array('route' => 'edit_profile'));

        // ... add more children

        return $menu;
    }
}