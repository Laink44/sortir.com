<?php

namespace App\DataFixtures;

use App\Entity\Villes;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class VillesFixtures extends Fixture
{
    public function load( ObjectManager $manager )
    {
        $faker = \Faker\Factory::create( 'fr_FR' );
        $json_source = file_get_contents( 'public/data/villes.json' );
        $json_data = json_decode( $json_source, true );

        $index = 1;
        
        foreach( $json_data as $city ){
            $ville = new Villes();
            $ville -> setNomVille( $city['Nom_commune'] );
            $ville -> setCodePostal( $city['Code_postal'] );
            $manager->persist( $ville );

            if( $index % 1000 === 0 ) {
                $manager -> flush();
                $manager -> clear();
                unset( $ville );
            }
            $index++;
        }
    }
}
