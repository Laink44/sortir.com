<?php
namespace App\Repository;

use App\Entity\Site;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use phpDocumentor\Reflection\Types\Mixed_;
use PhpParser\Node\Expr\Array_;

/**
 * @method Test|null find($id, $lockMode = null, $lockVersion = null)
 * @method Test|null findOneBy(array $criteria, array $orderBy = null)
 * @method Test[]    findAll()
 * @method Test[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SitesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Site::class);
    }

    public function getBySiteName(
        $siteName       = null,
        $currentPage    = 0,
        $maxResults     = 5
    ){
        $qb = $this ->createQueryBuilder( 's' );
        if( $siteName != null ) {
            $qb
                ->setParameter( 'nom_site', '%' . $siteName . '%' )
                ->andWhere( 's.nomSite LIKE :nom_site' );
        }
        $query =
            $qb
                ->orderBy( 's.nomSite', 'DESC' )
                ->setFirstResult( $currentPage )
                ->setMaxResults( $maxResults )
                ->getQuery();

        return $query -> getResult();
    }

    /** @return array */
    public function findAllSites() : array
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
        return $this -> createQueryBuilder( 's' ) -> orderBy( 's.nomSite', 'ASC' );
    }
}