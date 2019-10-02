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
     * @param SortiesRepository $sortiesRepository
     */
    public function __construct(ParticipantsRepository $participantsRepository,
                                SortiesRepository $sortiesRepository

    ) {
        $this->participantsRepository = $participantsRepository;
        $this->sortiesRepository = $sortiesRepository;
    }

    public function load(ObjectManager $manager)
    {

        $participant = $this->participantsRepository->findOneBy([]);
        $sortie = $this->sortiesRepository->findOneBy([]);
        $sortie->setId($sortie->getId()+1);
        for ($nbpart=1; $nbpart<=10; $nbpart ++) {
            $participant = $this->participantsRepository->find($participant->getId());
            $sortie = $this->sortiesRepository->find($sortie->getId());
            $faker = \Faker\Factory::create('fr_FR');
            $inscription = new Inscription();
            $inscription->setDate($faker->dateTimeBetween('-3 months'));
            $inscription->setParticipant($participant);
            $inscription->setSortie($sortie);
            $manager->persist($inscription);
            $sortie->setId($sortie->getId()+1);
            $participant->setId($participant->getId()+1);
        }
        $manager->flush();
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
