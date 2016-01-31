<?php

namespace Beluha\BlogBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Beluha\BlogBundle\Entity\Post;
use Beluha\BlogBundle\Entity\Category;
use Beluha\SecurityBundle\Entity\User;

/**
 * Description of LoadPostData
 * Fixtures for the Post Entity
 * @author Maria-Alexey
 */
class LoadPostData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }
    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 10;
    }

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setUsername('svid');
        $user->setEmail('alexey@beluha.pro');
        $encoder = $this->container->get('security.password_encoder');
        $password = $encoder->encodePassword($user, 'svid');
        $user->setPassword($password);        
        $manager->persist($user);
        
        $tagManager = $this->container->get('fpn_tag.tag_manager');
        
        $rootCategory = new Category();
        $rootCategory->setTitle('Главная');
        $webCategory = new Category();
        $webCategory->setTitle('Web-разработка');
        $webCategory->setParent($rootCategory);
        $manager->persist($rootCategory);
        $manager->persist($webCategory);
        
        $posts = [];
        
        $p1 = new Post();
        $p1->setTitle('Пробный тестовый пост');
        $p1->setPreviewText('В этом разделе мы будем ссылаться на файлы конфигурации служб, как на некоторые ресурсы.'
            . ' Это подчёркивает тот факт, что, хотя большинство ресурсов конфигурации будут представлены в виде файлов'
            . ' (например, YAML, XML, PHP), Symfony2 настолько гибок, что конфигурация может быть загружена'
            . ' практически отовсюду (например, из базы данных или даже через внешний веб-сервис).');
        $p1->setPreviewImg('symfony.png');
        $p1->setBody('При инициализации Symfony2 он создаёт контейнер служб, используя конфигурацию приложения (по умолчанию app/config/config.yml). '
            . 'Файл, который будет загружен, определяется методом AppKernel::registerContainerConfiguration(), который загружает файл, '
            . 'относящийся к конкретному окружению (например, config_dev.yml для dev или же config_prod.yml для prod). '
            . 'Экземпляр объекта Acme\HelloBundle\Mailer теперь можно получить через контейнер служб. '
            . 'контроллере Symfony2 при помощи вспомогательного метода get():  '
            . 'Когда запрашивается служба my_mailer, контейнер создаёт её объект и возвращает её. '
            . 'Это ещё одно преимущество от использования контейнера служб.  '
            . 'А именно, служба не создаётся вплоть до того момента, когда она будет нужна вам.');
        $p1->setDescription('Проба пера');
        $p1->setKeywords('тест, symfony2');
        $symfonyTag = $tagManager->loadOrCreateTag('symfony2');
        $testTag = $tagManager->loadOrCreateTag('тест');
        $tagManager->addTag($symfonyTag, $p1);
        $tagManager->addTag($testTag, $p1);
        $posts[] = $p1;
        
        $p2 = new Post();
        $p2->setTitle('Объекты в PHP 7');
        $p2->setPreviewText('На сегодняшний день разработчики PHP ведут '
            . 'работу над API уровня С. И в этом посте я буду по большей части рассказывать '
            . 'о внутренней разработке PHP, хотя если по ходу повествования встретится что-то '
            . 'интересное с точки зрения пользовательского уровня, то я буду делать отступление и объяснять.');
        $p2->setPreviewImg('symfony.png');
        $p2->setBody('Изменения в объектах по сравнению с PHP 5

Чтобы полностью вникнуть в тему объектов в PHP, рекомендую сначала ознакомиться с постом Подробно об объектах и классах в PHP.

Итак, что же изменилось в седьмой версии по сравнению с пятой?

    На пользовательском уровне почти ничего не изменилось. Иными словами, в PHP 7 объекты остались такими же, как и в PHP 5. Не было сделано каких-то глубоких изменений, ничего такого, что вы могли бы заметить в своей повседневной работе. Объекты ведут себя точно так же. Почему ничего не было изменено? Мы считаем, что наша объектная модель является зрелой, она очень активно используется, и мы не видим нужды вносить смуту в новых версиях PHP.
    Но всё же было несколько низкоуровневых улучшений. Изменения небольшие, тем не менее они требуют патчей расширений. В принципе, в PHP 7 внутренние объекты стали гораздо выразительнее, яснее и логичнее, чем в PHP 5. Самое главное нововведение связано с основным изменением в PHP 7: обновлением zval и управлением сборкой мусора. Но в этом посте мы не будем рассматривать последний, потому что тема поста — объекты. Однако нужно помнить, что сама природа новых zval и механизма сборки мусора оказывает влияние на внутреннее управление объектами.


Структура объекта и управление памятью

В первую очередь можете попрощаться с zend_object_value, от этой структуры в PHP 7 отказались.

Давайте посмотрим пример определения объекта zend_object:
<pre><code class="C++">
/* in PHP 5 */
typedef struct _zend_object {
    zend_class_entry *ce;
    HashTable *properties;
    zval **properties_table;
    HashTable *guards;
} zend_object;

/* in PHP 7 */
struct _zend_object {
    zend_refcounted_h gc;
    uint32_t          handle;
    zend_class_entry *ce;
    const zend_object_handlers *handlers;
    HashTable        *properties;
    zval              properties_table[1]; /* C struct hack */
};
</pre></code>

Как видите, есть небольшие отличия от PHP 5.

Во-первых, здесь содержится заголовок zend_refcounted_h, являющийся частью нового zval и механизма сборки мусора.

Во-вторых, теперь объект содержит свой handle, в то время как в PHP 5 эту задачу выполнял zend_object_store. А в PHP 7 у объектного хранилища (object store) уже гораздо меньше обязанностей.

В-третьих, для замещения properties_table вектора zval используется структурный хак на языке С, он пригодится при создании кастомных объектов.');
        $p2->setKeywords('Веб-разработка, PHP');
        $p2->setDescription('На сегодняшний день разработчики PHP ведут работу над API уровня С. И в этом посте я буду по большей части рассказывать о внутренней разработке PHP, хотя если...');
        $phpTag = $tagManager->loadOrCreateTag('php');
        $tagManager->addTag($phpTag, $p2);
        $posts[] = $p2;        
        
        
        $p3 = new Post();
        $p3->setTitle('DoctrineFixturesBundle ');
        $p3->setPreviewText('Fixtures are used to load a controlled set of data into a database. This data can be used for testing or could be the initial data required for the application to run smoothly. Symfony has no built in way to manage fixtures but Doctrine2 has a library to help you write fixtures for the Doctrine ORM or ODM.
Setup and Configuration¶

Doctrine fixtures for Symfony are maintained in the DoctrineFixturesBundle, which uses external Doctrine Data Fixtures library.

Follow these steps to install the bundle in your Symfony applications:
Step 1: Download the Bundle¶

Open a command console, enter your project directory and execute the following command to download the latest stable version of this bundle:');
        $p3->setPreviewImg('symfony.png');
        $p3->setBody('
Setup and Configuration¶

Doctrine fixtures for Symfony are maintained in the DoctrineFixturesBundle, which uses external Doctrine Data Fixtures library.

Follow these steps to install the bundle in your Symfony applications:
Step 1: Download the Bundle¶

Open a command console, enter your project directory and execute the following command to download the latest stable version of this bundle:
<pre><code class="php">
composer require --dev doctrine/doctrine-fixtures-bundle
</pre></code>

This command requires you to have Composer installed globally, as explained in the installation chapter of the Composer documentation.
Step 2: Enable the Bundle¶

Then, add the following line in the app/AppKernel.php file to enable this bundle only for the dev and test environments:

<pre><code class="php">
// app/AppKernel.php
// ...

class AppKernel extends Kernel
{
    public function registerBundles()
    {
        // ...
        if (in_array($this->getEnvironment(), array(\'dev\', \'test\'))) {
            $bundles[] = new Doctrine\Bundle\FixturesBundle\DoctrineFixturesBundle();
        }

        return $bundles
    }

    // ...
}
</pre></code>
Writing Simple Fixtures¶

Doctrine2 fixtures are PHP classes where you can create objects and persist them to the database. Like all classes in Symfony, fixtures should live inside one of your application bundles.

For a bundle located at src/AppBundle, the fixture classes should live inside src/AppBundle/DataFixtures/ORM or src/AppBundle/DataFixtures/MongoDB respectively for the ORM and ODM. This tutorial assumes that you are using the ORM, but fixtures can be added just as easily if you\'re using the ODM.

Imagine that you have a User class, and you\'d like to load one User entry:');
        $p3->setKeywords('symfony2, symfony, project, framework, php, php5, open-source, components, symphony, symfony framework, symfony tutorial');
        $p3->setDescription('Fixtures are used to load a controlled set of data into a database.');
        $symfonyOfTag = $tagManager->loadOrCreateTag('symfony documentation');
        $tagManager->addTag($symfonyTag, $p3);
        $tagManager->addTag($symfonyOfTag, $p3);
        $posts[] = $p3;        
        
        foreach ($posts as $post){
            $post->setAuthor($user);
            $post->setCategory($webCategory);
            $manager->persist($post);
        }
        $post = null;



        
        $manager->flush();
        
        foreach ($posts as $post){
            $tagManager->saveTagging($post);
        }        
    }

}
