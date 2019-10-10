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

    public function testPublishSortie()
    {
        $this->logInForm("admin","pass_1234");
        $crawler = $this->client->followRedirect();
        $this->assertSame(200, $this->client->getResponse()->getStatusCode());
        $crawler = $this->client->request('GET', '/sortie/create');
        $form = $crawler->filter('form[name="create_sortie"]')->form();
        $token = $crawler->filter('input[name="create_sortie[_token]"]')
            ->extract(array('value'))[0];
        $this->client->submit($form,[
            "create_sortie[nom]" => "Fake_Create_Sortie_Test",
            "create_sortie[datedebut]" => "2019-10-30T15:45:00",
            "create_sortie[datecloture]" => "2019-10-29 15:46",
            "create_sortie[nbinscriptionsmax]" => "4",
            "create_sortie[duree]" => "31",
            "create_sortie[descriptioninfos]" => "<p>Fake_Create_Sortie_Test</p>\r\n",
            "create_sortie[ville]" => "15179",
            "create_sortie[lieu]" => "3"
        ] );

        file_put_contents("output1.html", $this->client->getResponse()->getContent());
        $crawler = $this->client->followRedirect();
        file_put_contents("output2.html", $this->client->getResponse()->getContent());
        $this->assertGreaterThan(0, $crawler->filter('html:contains("La sortie est publié")')->count());
        $this->assertSame(200, $this->client->getResponse()->getStatusCode());

    }
    public function testUpdatePassword()
    {
        $this->logInForm("admin","pass_1234");
        $crawler = $this->client->followRedirect();
        $this->assertSame(200, $this->client->getResponse()->getStatusCode());
        $crawler = $this->client->request('GET', '/profil/editer');
        $form = $crawler->filter('form[name="edit_form"]')->form();
        //$token = $crawler->filter('input[name="create_sortie[_token]"]')
          //  ->extract(array('value'))[0];
        $this->client->submit($form,[
            "inputMotDePasse" => "pass_4321",
            "inputConfirmation" => "pass_4321",
        ] );
        $crawler = $this->client->request('GET', '/logout');
        $crawler = $this->client->followRedirect();
        $this->logInForm("admin","pass_4321");
        $crawler = $this->client->followRedirect();
        $this->assertSame(200, $this->client->getResponse()->getStatusCode());
        $this->assertGreaterThan(0, $crawler->filter('html:contains("Se déconnecter admin")')->count());
        $crawler = $this->client->request('GET', '/profil/editer');
        $form = $crawler->filter('form[name="edit_form"]')->form();
        //$token = $crawler->filter('input[name="create_sortie[_token]"]')
        //  ->extract(array('value'))[0];
        $this->client->submit($form,[
            "inputMotDePasse" => "pass_1234",
            "inputConfirmation" => "pass_1234",
        ] );
        $this->assertSame(200, $this->client->getResponse()->getStatusCode());
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
            'register[site]' => '1',
            'register[_token]' => '1'

        ]);
        $this->client->submit($form);
    }

}
