<?php

namespace MyTour\ExcursionBundle\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use MyTour\CoreBundle\Repository\BaseRepository;
use MyTour\CoreBundle\Utils\GlobalSession;
use MyTour\ExcursionBundle\Entity\Filter\TripFormFilter;
use MyTour\ExcursionBundle\Entity\Trip;
use MyTour\UserBundle\Entity\User;


/**
 * @extends ServiceEntityRepository<User>
 *
 * @method User|null find($id, $lockMode = null, $lockVersion = null, $onlyActive = true)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TripRepository extends BaseRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Trip::class);
    }

    /**
     * @param TripFormFilter $tripFormFilter
     * @return mixed
     */
    public function findByFilter(TripFormFilter $tripFormFilter)
    {
        $qb = $this->findByAbstractFilter($tripFormFilter);

        $qb->leftJoin('entity.traveler', 'traveler');

        if ($tripFormFilter->getTitle()){
            $qb
                ->andWhere('entity.title LIKE :title')
                ->setParameter('title', "%{$tripFormFilter->getTitle()}%");
        }

        if ($tripFormFilter->getDescription()){
            $qb
                ->andWhere('entity.description LIKE :description')
                ->setParameter('description', "%{$tripFormFilter->getDescription()}%");
        }

        if ($tripFormFilter->getPrice()){
            $qb
                ->andWhere('entity.price = :price')
                ->setParameter('price', $tripFormFilter->getPrice());
        }

        if ($tripFormFilter->getTraveler()){
            $qb
                ->andWhere($qb->expr()->eq('entity.traveler', ':traveler'))
                ->setParameter('traveler', $tripFormFilter->getTraveler());
        }

        return $qb
            ->orderBy('entity.title', 'ASC')
            ->getQuery();
    }
}