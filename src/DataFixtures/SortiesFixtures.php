<?php

namespace App\DataFixtures;

use App\Entity\Sortie;
use App\Repository\EtatsRepository;
use App\Repository\LieuxRepository;
use App\Repository\ParticipantsRepository;
use App\Repository\VillesRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;


class SortiesFixtures extends Fixture implements OrderedFixtureInterface
{
    /**
     * @var EntityManager
     */
    private $participantsRepository;
    private $villesRepository;
    /**
     * @var LieuxRepository
     */
    private $lieuxRepository;
    /**
     * @var EtatsRepository
     */
    private $etatsRepository;


    /**
     * SortiesFixtures constructor.
     * @param ParticipantsRepository $participantsRepository
     * @param VillesRepository $villesRepository
     * @param LieuxRepository $lieuxRepository
     * @param EtatsRepository $etatsRepository
     */
    public function __construct(ParticipantsRepository $participantsRepository,
                                VillesRepository $villesRepository,
                                LieuxRepository $lieuxRepository,
                                EtatsRepository $etatsRepository
    ) {
        $this->participantsRepository = $participantsRepository;
        $this->villesRepository = $villesRepository;
        $this->lieuxRepository = $lieuxRepository;
        $this->etatsRepository = $etatsRepository;
    }

    public function load( ObjectManager $manager )
    {
        $faker = \Faker\Factory::create( 'fr_FR' );
        $ville = $this->villesRepository->findOneBy([]);
        $villeId = ( $ville -> getNoVille() ) + rand ( 1 , 500 );
        $participant = $this->participantsRepository->findOneBy([]);
        $participantId = $participant -> getNoParticipant() ;
        $lieu = $this->lieuxRepository->findOneBy([]);
        $lieuId = $lieu -> getNoLieu() ;
        $etat = $this->etatsRepository->findOneBy([]);
        $etatId = $etat -> getNoEtat() ;

        for ($nbpart=1; $nbpart<=5; $nbpart ++) {
            $sortie = new Sortie();
            $newVille = $this->villesRepository->find( $villeId );
            $sortie->setNom("Sortie à ".$newVille->getNomVille());
            $sortie->setDatedebut($faker->dateTime);
            $sortie->setDatecloture($faker->dateTimeBetween($sortie->getDatedebut(), "+3 months"));
            $sortie->setDescriptioninfos($faker->paragraph(1));
            $sortie->setDuree($faker->randomDigitNotNull());
            $sortie->setNbinscriptionsmax($faker->randomDigitNotNull());

            $sortie->setOrganisateur( $participantId );
            $sortie->setLieuxNoLieu( $lieuId );
            $sortie->setEtatsNoEtat( $etatId );
            $manager->persist( $sortie );

            $villeId = $villeId + rand ( 1 , 20 );
            $lieuId++;
            $etatId++;
            $participantId++;
        }
        $manager-> flush();
    }

    public function getOrder()
    {
        return 7;
    }
}
