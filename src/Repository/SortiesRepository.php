<?php


namespace App\Repository;


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
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Sortie::class);
    }



    /** @return array */
    public function findAll() : array
    {
        return $this -> findAllQuery() -> getResult();
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