<?php

namespace App\DataFixtures;

use App\Entity\Participant;
use App\Repository\SitesRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class ParticipantsFixtures extends Fixture implements OrderedFixtureInterface
{
    private $encoder;
    /**
     * @var SitesRepository
     */
    private $sitesRepository;

    public function __construct(SitesRepository $sitesRepository, UserPasswordEncoderInterface $encoder) {
        $this->encoder = $encoder;
        $this->sitesRepository = $sitesRepository;
    }

    //Génère des participants fictifs
    public function load(ObjectManager $manager)
    {

        $faker = \Faker\Factory::create('fr_FR');
        for ($nbpart=1; $nbpart<=20; $nbpart ++) {
            $participant = new Participant();
            // ATTENTION : on s'assure de l'unicité
            $pseudo = $faker->unique()->userName;
            $participant -> setUsername( $pseudo);
            $participant -> setNom( $faker->lastName);
            $participant -> setPrenom($faker ->firstName);
            $phoneFr = $faker->numerify("06########");
            $participant -> setTelephone($phoneFr);
            $participant -> setMail(($faker->unique()->email));
            $password = $this->encoder->encodePassword($participant,'pass_1234');
            $participant ->setPassword($password);
            $participant -> setActif($faker->boolean);
            $participant -> setAdministrateur($faker->boolean);
            $idSite = $this->sitesRepository->findOneBy([])->getId() + rand ( 1 , 7 );
            $participant -> setSite($this->sitesRepository->find($idSite));
            $manager->persist($participant);




        }


        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }

    public function getOrder()
    {
        return 5;
    }
}
