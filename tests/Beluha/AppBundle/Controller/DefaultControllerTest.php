<?php

namespace Tests\BeluhaAppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/');

        $this->assertEquals(302, $client->getResponse()->getStatusCode());
        //$this->assertContains('Beluha\SecurityBundle\Controller\SecurityController::loginAction', $crawler->filter('h1')->text());
    }
}
