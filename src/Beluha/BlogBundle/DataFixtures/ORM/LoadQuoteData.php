<?php

namespace Beluha\BlogBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Beluha\BlogBundle\Entity\AuthorQuote;
use Beluha\BlogBundle\Entity\Quote;
use Beluha\SecurityBundle\Entity\User;

/**
 * Description of LoadQuoteData
 *
 * @author Beluha
 */
class LoadQuoteData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
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
        return 20;
    }
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $users = $this->container->get('doctrine')->getRepository('BeluhaSecurityBundle:User')->findAll();

        $a1 = new AuthorQuote();
        $a1->setName('А. Камю');

        $q1 = new Quote();
        $q1->setText('Осознание того, что мы умрем, превращает нашу жизнь в шутку.');
        $q1->setAuthor($a1);
        $q1->setByAdded($users[0]);
        $manager->persist($users[0]);
        $manager->persist($a1);
        $manager->persist($q1);

        $q2 = new Quote();
        $q2->setText('Высшая добродетель заключается в том, чтобы задушить свои страсти.');
        $q2->setAuthor($a1);
        $q2->setByAdded($users[0]);
        $manager->persist($q2);


        $q3 = new Quote();
        $q3->setText('Причины внутри нас самих, снаружи только оправдания…');
        $q3->setAuthor($a1);
        $q3->setByAdded($users[0]);
        $manager->persist($q3);


        $q4 = new Quote();
        $q4->setText('С несправедливостью либо сражаются, либо сотрудничают.');
        $q4->setAuthor($a1);
        $q4->setByAdded($users[0]);
        $manager->persist($q4);

        $q5 = new Quote();
        $q5->setText('Для большинства людей война означает конец одиночества. Для меня она — окончательное одиночество.');
        $q5->setAuthor($a1);
        $q5->setByAdded($users[0]);
        $manager->persist($q5);

        $a2 = new AuthorQuote();
        $a2->setName('Марина Цветаева');
        $manager->persist($a2);

        $q6 = new Quote();
        $q6->setText('Все женщины ведут в туманы.');
        $q6->setAuthor($a2);
        $q6->setByAdded($users[0]);
        $manager->persist($q6);
        
        $manager->flush();
        
    }
}