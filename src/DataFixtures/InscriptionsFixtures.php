<?php

namespace App\DataFixtures;

use App\Entity\Inscription;
use App\Entity\Participant;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class InscriptionsFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create( 'fr_FR' );
        $inscription = new Inscription();
        $partitipants = new Participant();
        $inscription->setDateInscription($faker->dateTimeBetween('-6 months'));
        //$idParticipant = $partitipants->getNoParticipant();
        //$inscription->setParticipantsNoParticipant();


        // $manager->persist($product);

        $manager->flush();
    }
}
