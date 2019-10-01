<?php

namespace App\DataFixtures;

use App\Entity\Lieu;
use App\Entity\Ville;
use App\Repository\LieuxRepository;
use App\Repository\ParticipantsRepository;
use App\Repository\VillesRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManager;

class LieuxFixtures extends Fixture implements OrderedFixtureInterface
{

    private $villesRepository;



    /**
     * SortiesFixtures constructor.
     * @param ParticipantsRepository $participantsRepository
     * @param VillesRepository $villesRepository
     * @param LieuxRepository $lieuxRepository
     */
    public function __construct(VillesRepository $villesRepository
    ) {
        $this->villesRepository = $villesRepository;
    }

    public function load( ObjectManager $manager )
    {
        $faker = \Faker\Factory::create( 'fr_FR' );
        $ville = $this->villesRepository->findOneBy([]);
        for( $index = 0; $index < 20; $index++ ) {
            $lieu = new Lieu();
            $lieu -> setNomLieu( $faker -> company );
            $lieu -> setLongitude( $faker -> longitude );
            $lieu -> setLatitude( $faker -> latitude );
            $lieu -> setVillesNoVille( $ville->getNoVille() );
            $lieu ->setRue("13 rue des colombes");

            $manager->persist($lieu);
        }

        $manager-> flush();
    }

    public function getOrder()
    {
        return 2;
    }
}
