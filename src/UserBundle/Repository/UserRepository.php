<?php

namespace MyTour\UserBundle\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use MyTour\UserBundle\Entity\Filter\UserFormFilter;
use MyTour\UserBundle\Entity\User;


/**
 * @extends ServiceEntityRepository<User>
 *
 * @method User|null find($id, $lockMode = null, $lockVersion = null, $onlyActive = true)
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

        if ($userFormFilter->getName()){
            $qb
                ->andWhere('entity.name LIKE :name')
                ->setParameter('name', "%{$userFormFilter->getName()}%");
        }

        if ($userFormFilter->getUsername()){
            $qb
                ->andWhere('entity.username LIKE :username')
                ->setParameter('username', "%{$userFormFilter->getUsername()}%");
        }

        if ($userFormFilter->getBirthday()){
            $qb
                ->andWhere($qb->expr()->eq('DATE(entity.birthday)', ':birthday'))
                ->setParameter('birthday', $userFormFilter->getBirthday()->format('Y-m-d'));
        }

        if ($userFormFilter->getRole()){
            $qb->andWhere($qb->expr()->like('entity.roles', "'%[\"" . $userFormFilter->getRole() . "\"]%'"));
        }

        return $qb
            ->orderBy('entity.name', 'ASC')
            ->getQuery();
    }
}