<?php

namespace App\DataFixtures;

use App\Entity\Villes;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class EtatsFixtures extends Fixture
{
    public function load( ObjectManager $manager )
    {
        $faker = \Faker\Factory::create( 'fr_FR' );
        $json_source = file_get_contents( 'public/data/etats.json' );
        $json_data = json_decode( $json_source, true );
        foreach( $json_data as $states ){
            $etat = new Villes();
            $etat -> setNomVille( $states['libelle'] );
            $manager->persist( $etat );
        }
        $manager-> flush();
    }
}
