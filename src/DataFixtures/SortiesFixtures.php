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
        for ($nbpart=1; $nbpart<=5; $nbpart ++) {
            $sortie = new Sortie();

            $ville = $this->villesRepository->findOneBy([]);
            $participant = $this->participantsRepository->findOneBy([]);
            $lieu = $this->lieuxRepository->findOneBy([]);
            $etat = $this->etatsRepository->findOneBy([]);

            $sortie->setNom("Sortie à ".$ville->getNomVille());
            $sortie->setDatedebut($faker->dateTime);
            $sortie->setDatecloture($faker->dateTimeBetween($sortie->getDatedebut(), "+3 months"));
            $sortie->setDescriptioninfos($faker->paragraph(1));
            $sortie->setDuree($faker->randomDigitNotNull());
            $sortie->setNbinscriptionsmax($faker->randomDigitNotNull());

            $sortie->setOrganisateur($participant->getNoParticipant());
            $sortie->setLieuxNoLieu($lieu->getNoLieu());
            $sortie->setEtatsNoEtat($etat->getNoEtat());
            $manager->persist( $sortie );
        }
        $manager-> flush();
    }

    public function getOrder()
    {
        return 7;
    }
}
