<?php


namespace App\Command;

use App\Entity\Etat;
use App\Entity\Sortie;
use App\Repository\SortiesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class UpdateSortieState extends ContainerAwareCommand
{
    // the name of the command (the part after "bin/console")
    protected static $defaultName = 'app:update-sorties-state';
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager ,$name = null) {
        parent::__construct($name);

        $this->entityManager = $entityManager;
    }

    protected function configure()
    {
        $this
            // the short description shown while running "php bin/console list"
            ->setDescription('Update all sortie state from database.')

            // the full command description shown when running the command with
            // the "--help" option
            ->setHelp('This command allows you to update all sortie state from database.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        date_default_timezone_set('Europe/Paris');
        $doctrine = $this->getContainer()->get('doctrine');

        $sorties = $doctrine->getRepository(Sortie::class)->findAll();
        $etatRepository =  $doctrine->getRepository(Etat::class);
        //dump( $this->entityManager);
        $passedState =  $etatRepository->findOneBy(array('libelle' => "Passée"));
        $runningState =  $etatRepository->findOneBy(array('libelle' => "Activité en cours"));
        $closedState =  $etatRepository->findOneBy(array('libelle' => "Clôturée"));

        foreach ($sorties as $sortie){
            $date_end = clone $sortie->getDatedebut();
            $date_end->add(new \DateInterval('PT' .  $sortie->getDuree() . 'M'));
            $str = $date_end->format('Y-m-d H:i');
            $now = new \DateTime();

            if ($date_end <= new \DateTime()){

                $output->writeln($sortie->getNom() . ' ' ."Passée: ". $str);
                $sortie->setEtat($passedState);
            }
            elseif ($sortie->getDatedebut() <= $now)
            {
                if ( $sortie->getDatedebut() <= $now && $now < $date_end ){
                    $output->writeln( $sortie->getNom() . ' ' . "Activité en cours: (Fin) => " . $str);
                    $sortie->setEtat($runningState);
                }
                else{
                    //ouvert ou créee (planifié)
                    $output->writeln( $sortie->getNom() . ' Planifiée: (Début) => '. $sortie->getDatedebut()->format('Y-m-d H:i'));
                }

            }
            elseif ($sortie->getDatecloture() >= $now){
                $output->writeln($sortie->getNom() . ' ' . "Inscriptions Clôturée: (Début) => ". $sortie->getDatedebut()->format('Y-m-d H:i'));
                $sortie->setEtat($closedState);
            }
            else {
                $output->writeln($sortie->getNom() . ' ' . "Erreur /!\ ");
            }
            $this->entityManager->persist($sortie);
            $this->entityManager->flush();
        }
       //dump($SortieRepo);
    }
}