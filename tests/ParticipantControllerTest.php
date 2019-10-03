<?php

namespace App\Tests;

use App\Entity\Participant;
use App\Entity\Site;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\Security\Core\Role\Role;

class ParticipantControllerTest extends WebTestCase
{
   /* public function testHomePage()
    {
        $crawler =   $this->client->request('GET', '/');

      //  $this->assertSame(200,  $this->client->getResponse()->getStatusCode());
        //$this->assertContains('Connexion', $crawler->filter('h1')->text());
    } */

   public  function  __construct($name = null, array $data = [], $dataName = '')
   {
       parent::__construct($name, $data, $dataName);
   }

    private $client = null;

    public function setUp()
    {
        $this->client = static::createClient();
    }

    public function testSecuredPage()
    {
        $this->logInForm("admin","pass_1234");
        $crawler = $this->client->followRedirect();
        $this->assertSame(200, $this->client->getResponse()->getStatusCode());
        $this->assertGreaterThan(0, $crawler->filter('html:contains("Se déconnecter admin")')->count());
    }

    public function testRegister()
    {
        $this->registrerForm();
        $crawler = $this->client->followRedirect();
        $this->assertSame(200, $this->client->getResponse()->getStatusCode());
        $this->assertGreaterThan(0, $crawler->filter('html:contains("Connexion")')->count());
        $this->logInForm("user_fake","pass_1234");
        $crawler = $this->client->followRedirect();
        $this->assertSame(200, $this->client->getResponse()->getStatusCode());
        $this->assertGreaterThan(0, $crawler->filter('html:contains("Se déconnecter user_fake")')->count());
    }


    private function logInForm($username, $password){

        $crawler = $this->client->request('GET', '/login');
        $buttonCrawlerNode = $crawler->selectButton('Se connecter');
        $form = $buttonCrawlerNode->form();
        $form = $buttonCrawlerNode->form([
            '_username'    => $username,
            '_password' =>$password,
        ]);
        $this->client->submit($form);
    }

    private function registrerForm(){

        $crawler = $this->client->request('GET', '/register');
        $buttonCrawlerNode = $crawler->selectButton('Enregistrer');
        $form = $buttonCrawlerNode->form();
        $form = $buttonCrawlerNode->form([
            'register[username]'    => 'user_fake',
            'register[prenom]'    => 'prenom_fake',
            'register[nom]'    => 'nom_fake',
            'register[telephone]' => '0600112244',
            'register[mail]' => 'user_fake@sortir.com',
            'register[password][first]' => 'pass_1234',
            'register[password][second]' => 'pass_1234',
            'register[site]' => '1'

        ]);
        $this->client->submit($form);
    }

}
