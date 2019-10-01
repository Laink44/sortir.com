<?php

namespace App\DataFixtures;

use App\Entity\Lieu;
use App\Entity\Ville;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManager;

class LieuxFixtures extends Fixture
{
    protected $entityManager;

    /**
     * LieuxFixtures constructor.
     * @param EntityManager $entityManager
     */
    public function __construct( EntityManager $entityManager ) {
        $this -> entityManager = $entityManager;
    }

    public function load( ObjectManager $manager )
    {
        $faker = \Faker\Factory::create( 'fr_FR' );
        $villesRepository = $this -> entityManager -> getRepository( Ville::class );
        $allVilles = $villesRepository -> findAll();
        $allVillesDraw = array_rand( $allVilles, 20 );

        for( $index = 0; $index < 20; $index++ ) {
            $lieu = new Lieu();
            $lieu -> setNomLieu( $faker -> company );
            $lieu -> setLongitude( $faker -> longitude );
            $lieu -> setLatitude( $faker -> longitude );
            $lieu -> setVillesNoVille( $allVillesDraw[ $index ] -> getNoVille );
        }

        $manager-> flush();
    }

    public function getOrder()
    {
        return 2;
    }
}
