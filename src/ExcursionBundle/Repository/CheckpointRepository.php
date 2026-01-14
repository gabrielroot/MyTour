<?php

namespace MyTour\ExcursionBundle\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use MyTour\CoreBundle\Repository\BaseRepository;
use MyTour\CoreBundle\Utils\GlobalSession;
use MyTour\ExcursionBundle\Entity\Filter\CheckpointFormFilter;
use MyTour\ExcursionBundle\Entity\Checkpoint;
use MyTour\UserBundle\Entity\User;


/**
 * @extends ServiceEntityRepository<User>
 *
 * @method User|null find($id, $lockMode = null, $lockVersion = null, $onlyActive = true)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CheckpointRepository extends BaseRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Checkpoint::class);
    }

    /**
     * @param CheckpointFormFilter $checkpointFormFilter
     * @return mixed
     */
    public function findByFilter(CheckpointFormFilter $checkpointFormFilter)
    {
        $qb = $this->findByAbstractFilter($checkpointFormFilter);

        $qb->leftJoin('entity.trip', 'trip');

        if ($checkpointFormFilter->getTitle()){
            $qb
                ->andWhere('entity.title LIKE :title')
                ->setParameter('title', "%{$checkpointFormFilter->getTitle()}%");
        }

        if ($checkpointFormFilter->getDescription()){
            $qb
                ->andWhere('entity.description LIKE :description')
                ->setParameter('description', "%{$checkpointFormFilter->getDescription()}%");
        }

        if ($checkpointFormFilter->getLatitude()){
            $qb
                ->andWhere('entity.latitude = :latitude')
                ->setParameter('latitude', $checkpointFormFilter->getLatitude());
        }

        if ($checkpointFormFilter->getLongitude()){
            $qb
                ->andWhere('entity.longitude = :longitude')
                ->setParameter('longitude', $checkpointFormFilter->getLongitude());
        }

        if ($checkpointFormFilter->getEstimatedDateTime()) {
            $qb
                ->where('entity.estimatedDateTime = :estimatedDateTime')
                ->setParameter('estimatedDateTime', $checkpointFormFilter->getEstimatedDateTime());
        }

        if ($checkpointFormFilter->getVisitedDateTime()) {
            $qb
                ->where('entity.estimatedDateTime = :visitedDateTime')
                ->setParameter('visitedDateTime', $checkpointFormFilter->getVisitedDateTime());
        }

        if ($checkpointFormFilter->getTrip()){
            $qb
                ->andWhere($qb->expr()->eq('entity.trip', ':trip'))
                ->setParameter('trip', $checkpointFormFilter->getTrip());
        }

        return $qb
            ->orderBy('entity.title', 'ASC')
            ->getQuery();
    }
}