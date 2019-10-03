<?php


namespace App\Repository;


use App\Entity\Participant;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\NonUniqueResultException;
use Symfony\Bridge\Doctrine\Security\User\UserLoaderInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class ParticipantsRepository extends ServiceEntityRepository implements UserLoaderInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Participant::class);
    }

    public function first() : ?Participant
    {
        try {
            RETURN $this->createQueryBuilder(null)->select('participant')
                ->from("App:Participant", "participant")
                ->setMaxResults(1)
                ->getQuery()
                ->getOneOrNullResult();
        } catch (NonUniqueResultException $e) {
        }
    }

    /**
     * Loads the user for the given username.
     *
     * This method must return null if the user is not found.
     *
     * @param string $username The username
     *
     * @return UserInterface|null
     */
    public function loadUserByUsername($username)
    {
        $qb = $this->createQueryBuilder('p');
        $qb->where('p.username = :username OR p.mail = :mail');
        $qb->setParameter('username', $username);
        $qb->setParameter('mail', $username);
        return $qb->getQuery()->getOneOrNullResult();
    }
}