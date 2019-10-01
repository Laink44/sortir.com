<?php

namespace App\DataFixtures;

use App\Entity\Lieu;
use App\Repository\VillesRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LieuxFixtures extends Fixture implements OrderedFixtureInterface
{
    private $villesRepository;

    /**
     * LieuxFixtures constructor.
     * @param VillesRepository $villesRepository
     */
    public function __construct( VillesRepository $villesRepository ){
        $this->villesRepository = $villesRepository;
    }

    public function load( ObjectManager $manager ){
        $faker = \Faker\Factory::create( 'fr_FR' );
        $ville = $this -> villesRepository -> findOneBy( [] );
        $villeId = ( $ville -> getNoVille() ) + rand ( 1 , 500 );

        for( $index = 0; $index < 20; $index++ ) {
            $lieu = new Lieu();
            $lieu -> setNomLieu( $faker -> company );
            $lieu -> setLongitude( $faker -> longitude );
            $lieu -> setLatitude( $faker -> latitude );
            $lieu -> setRue( $faker -> streetName );
            $lieu -> setVillesNoVille( $villeId );
            $manager -> persist( $lieu );
            $villeId++;
        }

        $manager-> flush();
    }

    public function getOrder(){
        return 2;
    }
}
