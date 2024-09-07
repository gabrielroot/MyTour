<?php

namespace MyTour\UserBundle\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use MyTour\UserBundle\Entity\Filter\UserFormFilter;
use MyTour\UserBundle\Entity\User;


/**
 * @extends ServiceEntityRepository<User>
 *
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends BaseRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * @param UserFormFilter $userFormFilter
     * @return mixed
     */
    public function findByFilter(UserFormFilter $userFormFilter)
    {
        $qb = $this->findByAbstractFilter($userFormFilter);

        if ($userFormFilter->getUsername()){
            $qb
                ->andWhere('entity.username LIKE :username')
                ->setParameter('username', "%{$userFormFilter->getUsername()}%");
        }

        if ($userFormFilter->getRole()){
            $qb->andWhere($qb->expr()->like('entity.roles', "'%[\"" . $userFormFilter->getRole() . "\"]%'"));
        }

        return $qb
            ->orderBy('entity.username', 'ASC')
            ->getQuery();
    }
}