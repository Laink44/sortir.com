<?php

namespace App\DataFixtures;

use App\Entity\Ville;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class VillesFixtures extends Fixture
{
    public function load( ObjectManager $manager )
    {
        $faker = \Faker\Factory::create( 'fr_FR' );
        $json_source = file_get_contents( 'public/data/villes.json' );
        $json_data = json_decode( $json_source, true );
        foreach( $json_data as $city ){
            $ville = new Ville();
            $ville -> setNomVille( $city['Nom_commune'] );
            $ville -> setCodePostal( $city['Code_postal'] );
            $manager->persist( $ville );
        }
        $manager-> flush();
    }
}
