<?php

namespace App\DataFixtures;

use App\Entity\Participants;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class ParticipantsFixtures extends Fixture
{
    private $encoder;
    public function __construct(UserPasswordEncoderInterface $encoder) {
        $this->encoder = $encoder;
    }

    //Génère des participants fictifs
    public function load(ObjectManager $manager)
    {

        $faker = \Faker\Factory::create('fr_FR');
        for ($nbpart=1; $nbpart<=5; $nbpart ++) {
            $participant = new Participants();
            // ATTENTION : on s'assure de l'unicité
            $participant -> setPseudo( strtolower( substr($faker->unique()->firstName,2).(substr($faker->unique()->lastName,3))));
            $participant -> setNom( $faker->lastName);
            $participant -> setPrenom($faker ->firstName);
            $participant -> setTelephone(substr(($faker->unique()->phoneNumber),0,10));
            $participant -> setMail(($faker->unique()->email));
            $password = $this->encoder->encodePassword($participant,'pass_1234"');
            $participant ->setMotDePasse($password);
            $participant -> setActif($faker->boolean);
            $participant -> setAdministrateur($faker->boolean);
            $participant -> setSitesNoSite($faker->randomDigit);
            $manager->persist($participant);




        }


        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }
}
