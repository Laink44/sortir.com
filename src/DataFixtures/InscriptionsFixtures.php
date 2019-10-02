<?php

namespace App\DataFixtures;

use App\Entity\Inscription;
use App\Entity\Participant;
use App\Repository\EtatsRepository;
use App\Repository\LieuxRepository;
use App\Repository\ParticipantsRepository;
use App\Repository\SortiesRepository;
use App\Repository\VillesRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class InscriptionsFixtures extends Fixture implements  OrderedFixtureInterface
{
    /**
     * @var SortiesRepository
     */
    private $sortiesRepository;
    /**
     * @var ParticipantsRepository
     */
    private $participantsRepository;

    /**
     * SortiesFixtures constructor.
     * @param ParticipantsRepository $participantsRepository
     * @param SortiesRepository $villesRepository
     */
    public function __construct(ParticipantsRepository $participantsRepository,
                                SortiesRepository $sortiesRepository

    ) {
        $this->participantsRepository = $participantsRepository;
        $this->sortiesRepository = $sortiesRepository;
    }

    public function load(ObjectManager $manager)
    {
      /*  $faker = \Faker\Factory::create( 'fr_FR' );
        $inscription = new Inscription();
        $inscription->setDateInscription($faker->dateTimeBetween('-3 months'));
        $participant = $this->participantsRepository->findOneBy([]);
        $sortie = $this->sortiesRepository->findOneBy([]);

        $inscription->setParticipantsNoParticipant($participant->getNoParticipant());
        $inscription->setSortiesNoSortie($sortie->getNoSortie());
        $manager->persist($inscription);

        $manager->flush();*/
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    public function getOrder()
    {
      return 8;
    }
}
