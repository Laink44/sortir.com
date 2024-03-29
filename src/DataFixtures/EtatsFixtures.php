<?php

namespace App\DataFixtures;

use App\Entity\Etat;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class EtatsFixtures extends Fixture implements OrderedFixtureInterface
{
    public function load( ObjectManager $manager )
    {
        $faker = \Faker\Factory::create( 'fr_FR' );
        $json_source = file_get_contents( 'public/data/etats.json' );
        $json_data = json_decode( $json_source, true );
        foreach( $json_data as $states ){
            $etat = new Etat();
            $etat -> setLibelle( $states['libelle'] );
            $manager->persist( $etat );
        }
        $manager-> flush();
    }

    public function getOrder()
    {
        return 3;
    }
}
