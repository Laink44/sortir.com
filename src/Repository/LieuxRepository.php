<?php
namespace App\Repository;

use App\Entity\Lieu;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;


/**
 * @method Lieu|null find($id, $lockMode = null, $lockVersion = null)
 * @method Lieu|null findOneBy(array $criteria, array $orderBy = null)
 * @method Lieu[]    findAll()
 * @method Lieu[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LieuxRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Lieu::class);
    }

	public function  findLieuByVilleId($lieuid=1){
        $qb= $this->createQueryBuilder('l')->select('l')
        ->join("l.ville","v","WITH", "l.ville=v")
        ->Where('v.id = :vid')
            ->setParameter('vid', $lieuid);
        $query = $qb->getQuery();
        return $query->getResult();
    }

    public function getByLocationName(
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

    /**
     * @return int
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getLocationCount() : int {
        return $this
            ->createQueryBuilder( 'p' )
            ->select( 'COUNT( p )' )
            ->getQuery()
            ->getSingleScalarResult();
    }

    /**
     * @return int
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getLocationCountByName( $locationName ) : int {
        $qb =   $this
            ->createQueryBuilder( 'c' )
            ->select( 'COUNT( c )' );

        if( $locationName != null ) {
            $qb
                -> setParameter( 'nom_lieu', '%' . $locationName . '%' )
                -> andWhere( 'c.nomLieu LIKE :nom_lieu' );
        }

        return $qb -> getQuery() ->getSingleScalarResult();
    }

    /** @return array */
    public function findAllLieux( int $offset, int $maxByPage ) : array
    {
        return  $this
            -> findAllQuery()
            -> setFirstResult( $offset )
            -> setMaxResults( $maxByPage )
            -> getResult();
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