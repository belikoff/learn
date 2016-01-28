<?php

namespace Beluha\BlogBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Beluha\BlogBundle\Entity\AuthorQuote;
use Beluha\BlogBundle\Entity\Quote;

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
        $manager->persist($users[0]);
        $manager->persist($a1);

        $quoteArray1 = [];

        $q1 = new Quote();
        $q1->setText('Осознание того, что мы умрем, превращает нашу жизнь в шутку.');
        $quoteArray1[] = $q1;

        $q2 = new Quote();
        $q2->setText('Высшая добродетель заключается в том, чтобы задушить свои страсти.');
        $quoteArray1[] = $q2;

        $q3 = new Quote();
        $q3->setText('Причины внутри нас самих, снаружи только оправдания…');
        $quoteArray1[] = $q3;

        $q4 = new Quote();
        $q4->setText('С несправедливостью либо сражаются, либо сотрудничают.');
        $quoteArray1[] = $q4;

        $q5 = new Quote();
        $q5->setText('Для большинства людей война означает конец одиночества. Для меня она — окончательное одиночество.');
        $quoteArray1[] = $q5;

        foreach ($quoteArray1 as $quote) {
            $quote->setAuthor($a1);
            $quote->setByAdded($users[0]);
            $manager->persist($quote);
        }


        $a2 = new AuthorQuote();
        $a2->setName('Марина Цветаева');
        $manager->persist($a2);

        $q6 = new Quote();
        $q6->setText('Все женщины ведут в туманы.');
        $q6->setAuthor($a2);
        $q6->setByAdded($users[0]);
        $manager->persist($q6);
        
        $a3 = new AuthorQuote();
        $a3->setName('Брайан Трейси');
        $manager->persist($a3);  
    
        $q7 = new Quote();
        $q7->setText('«Некоторые руководители не уверены, что им стоит обучать сотрудников: «А что если мы их научим, а они уйдут?». Это неправильный вопрос. Правильный вопрос: «А что если мы их не научим, а они останутся?»');
        $q7->setAuthor($a3);
        $q7->setByAdded($users[0]);
        $manager->persist($q7);

        $manager->flush();
    }
}
