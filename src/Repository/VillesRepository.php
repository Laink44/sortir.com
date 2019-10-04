<?php
namespace App\Repository;

use App\Entity\Ville;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;

/**
 * @method Test|null find($id, $lockMode = null, $lockVersion = null)
 * @method Test|null findOneBy(array $criteria, array $orderBy = null)
 * @method Test[]    findAll()
 * @method Test[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VillesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Ville::class);
    }

    public function getByVilleName(
        $villeName       = null,
        $currentPage    = 0,
        $maxResults     = 5
    ){
        $qb = $this ->createQueryBuilder( 's' );
        if( $villeName != null ) {
            $qb
                ->setParameter( 'nom_ville', '%' . $villeName . '%' )
                ->andWhere( 's.nomVille LIKE :nom_ville' );
        }
        $query =
            $qb
                ->orderBy( 's.nomVille', 'DESC' )
                ->setFirstResult( $currentPage )
                ->setMaxResults( $maxResults )
                ->getQuery();

        return $query -> getResult();
    }


    public function findVilleByLieuId($lieuId = 1) {
        $qb = $this->createQueryBuilder('v')->select('v')
        ->join("v.lieus","l","WITH", "l.ville = v")
        ->Where('l.id = :lid')
            ->setParameter('lid', $lieuId);
        $query = $qb->getQuery();
        return $query->getResult();
    }

    /** @return array */
    public function findAllVilles() : array
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
        return $this -> createQueryBuilder( 's' ) -> orderBy( 's.nomVille', 'ASC' );
    }
}