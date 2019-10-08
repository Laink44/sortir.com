<?php
namespace App\Repository;

use App\Entity\Ville;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;

/**
 * @method Ville|null find($id, $lockMode = null, $lockVersion = null)
 * @method Ville|null findOneBy(array $criteria, array $orderBy = null)
 * @method Ville[]    findAll()
 * @method Ville[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
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
        $qb = $this -> createQueryBuilder( 's' );
        if( $villeName != null ) {
            $qb
                -> setParameter( 'nom_ville', '%' . $villeName . '%' )
                -> andWhere( 's.nomVille LIKE :nom_ville' );
        }
        $query =
            $qb
                -> orderBy( 's.nomVille', 'DESC' )
                -> setFirstResult( $currentPage )
                -> setMaxResults( $maxResults )
                -> getQuery();

        return $query -> getResult();
    }


    public function getCPVilleByNameVille($nomville){
        $qb = $this->createQueryBuilder('v');
        $qb->select('v.codePostal')
            ->where('v.nomVille LIKE :nomville')
            ->setParameter('nomville',$nomville);
        $qb-> setMaxResults(1);
        $query = $qb->getQuery();
        return $query->getResult();


    }

    public function getByVilleNameStartingWith(
        $villeName       = null,
        $currentPage    = 0,
        $maxResults     = 5
    ){
        $qb = $this -> createQueryBuilder( 's' );
        if( $villeName != null ) {
            $qb
                -> setParameter( 'nom_ville', $villeName . '%' )
                -> andWhere( 's.nomVille LIKE :nom_ville' );
        }
        $query =
            $qb
                -> orderBy( 's.nomVille', 'ASC' )
                -> setFirstResult( $currentPage )
                -> setMaxResults( $maxResults )
                -> getQuery();

        return $query -> getResult();
    }


    public function findByNameAndCodePostal( $codePostal = '' ) {
        $qb = $this -> createQueryBuilder( 'c' );

        if( $codePostal != null ) {
            $qb
                -> setParameter( 'code_postal', '%' . $codePostal . '%' )
                -> andWhere( 'c.codePostal LIKE :code_postal' );
        }

        return $qb -> getQuery() -> getResult();
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