<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\BrowserKit\Cookie;

class ParticipantControllerTest extends WebTestCase
{
    public function testHomePage()
    {
        $crawler =   $this->client->request('GET', '/');

        $this->assertSame(200,  $this->client->getResponse()->getStatusCode());
        $this->assertContains('Connexion', $crawler->filter('h1')->text());
    }

    private $client = null;

    public function setUp()
    {
        $this->client = static::createClient();
    }

    public function testSecuredHello()
    {
        $this->logIn();

        $crawler = $this->client->request('GET', '/admin/site');

        $this->assertSame(200, $this->client->getResponse()->getStatusCode());
      //  $this->assertGreaterThan(0, $crawler->filter('html:contains("Admin Dashboard")')->count());
    }
    private function logIn()
    {
        $session = $this->client->getContainer()->get('session');

        // the firewall context (defaults to the firewall name)
        $firewall = 'main';

        $token = new UsernamePasswordToken('admin', null, $firewall, array('ROLE_ADMIN'));
        $session->set('_security_'.$firewall, serialize($token));
        $session->save();

        $cookie = new Cookie($session->getName(), $session->getId());
        $this->client->getCookieJar()->set($cookie);
    }
}
