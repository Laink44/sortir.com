<?php


namespace App\Repository;



use App\Entity\Lieu;
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
class LieuxRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Lieu::class);
    }

    public function getByLieuName(
        $lieuName       = null,
        $currentPage    = 0,
        $maxResults     = 5
    ){
        $qb = $this ->createQueryBuilder( 's' );
        if( $lieuName != null ) {
            $qb
                ->setParameter( 'nom_lieu', '%' . $lieuName . '%' )
                ->andWhere( 's.nomLieu LIKE :nom_lieu' );
        }
        $query =
            $qb
                ->orderBy( 's.nomLieu', 'DESC' )
                ->setFirstResult( $currentPage )
                ->setMaxResults( $maxResults )
                ->getQuery();

        return $query -> getResult();
    }

    /** @return array */
    public function findAllLieux() : array
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
        return $this -> createQueryBuilder( 's' ) -> orderBy( 's.nomLieu', 'ASC' );
    }
}