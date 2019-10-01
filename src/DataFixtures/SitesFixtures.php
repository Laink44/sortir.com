<?php

namespace App\DataFixtures;

use App\Entity\Sites;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class SitesFixtures extends Fixture
{
    public function load( ObjectManager $manager )
    {
        $faker = \Faker\Factory::create( 'fr_FR' );
        $json_source = file_get_contents( 'public/data/sites.json' );
        $json_data = json_decode( $json_source, true );
        foreach( $json_data as $location ){
            $site = new Sites();
            $site -> setNomSite( $location['nom'] );
            $manager->persist( $site );
        }
        $manager-> flush();
    }
}
