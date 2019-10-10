<?php


namespace App\Repository;


use App\Dto\RequestFindSeries;
use App\Entity\Etat;
use App\Entity\Inscription;
use App\Entity\Participant;
use App\Entity\Sortie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;

class SortiesRepository extends ServiceEntityRepository
{
    /**
     * @var EtatsRepository
     */
    private $etatsRepository;

    public function __construct(ManagerRegistry $registry, EtatsRepository $etatsRepository)
    {
        parent::__construct($registry, Sortie::class);
        $this->etatsRepository = $etatsRepository;
    }


    /**
     * @param RequestFindSeries|null $dto
     * @return array
     */
    public function findAllOpened(RequestFindSeries $dto = null,  Participant $participant = null) : array
    {
         $query = $this -> createQueryBuilder( 's' );
         if ($dto != null) {
             if ($dto->getSite()) {
                 $query = $query
                     ->join("s.organisateur","organisateur","WITH", "s.organisateur=organisateur")
                     ->andWhere('organisateur.site = :site')
                     ->setParameter('site', $dto->getSite());
             }
             if ($dto->getDateDebut() && $dto->getDateFin()) {
                 $from = new \DateTime($dto->getDateDebut()->format("Y-m-d")." 00:00:00");
                 $to   = new \DateTime($dto->getDateFin()->format("Y-m-d")." 23:59:59");
                 $query = $query->andWhere('s.datedebut BETWEEN :from AND :to')
                     ->setParameter('from', $from)
                     ->setParameter('to', $to);
             }

             if ($dto->getKeyword() ) {
                 $query = $query->andWhere('s.nom like :keyword')
                     ->setParameter('keyword', '%'.$dto->getKeyword().'%');
             }

             if ($dto->isOutDatedFilter()) {
                 $passedState = $this->etatsRepository->findOneBy(array('libelle' => "Passée"));
                 $query = $query->andWhere('s.etat = :etat')
                     ->setParameter('etat', $passedState);
             }
             else {
                 $openState = $this->etatsRepository->findOneBy(array('libelle' => "Créée"));
                 $query = $query->andWhere('s.etat != :etat or s.organisateur = :organisateur')
                     ->setParameter('etat', $openState)
                    ->setParameter('organisateur', $participant);
             }
             if ($dto->isManagerFilter()) {
                 $query = $query->andWhere('s.organisateur = :participant')
                     ->setParameter('participant', $participant);
             }

             if ($dto->isRegisterFilter()) {
                 $query = $query
                     ->leftJoin("s.inscriptions","i")
                     ->andWhere("i.participant = :participantInscription")
                     ->setParameter('participantInscription', $participant);
             }
             else  if ($dto->isNotRegisterFilter())
             {
                     $query = $query
                         ->leftJoin("s.inscriptions","i", "WITH", " i.participant = :participantInscription")
                         ->andWhere("i.participant is NULL")
                         ->setParameter('participantInscription', $participant);
                 dump($query->getQuery()->getDQL());
             }
         }
         else {
             $openState = $this->etatsRepository->findOneBy(array('libelle' => "Créée"));
             $query = $query->andWhere('s.etat != :etat or s.organisateur = :organisateur')
                 ->setParameter('etat', $openState)
                 ->setParameter('organisateur', $participant);
         }
         return $query->getQuery()->getResult();
    }




    /** @return Query */
    public function findAllQuery() : Query
    {
        return $this -> findAllQueryBuilder() -> getQuery();
    }

    /** @return QueryBuilder */
    public function findAllQueryBuilder() : QueryBuilder
    {
        return $this -> createQueryBuilder( 's' ) -> orderBy( 's.nom', 'ASC' );
    }
}