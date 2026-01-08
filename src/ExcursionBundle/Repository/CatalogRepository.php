<?php

namespace MyTour\ExcursionBundle\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use MyTour\CoreBundle\Repository\BaseRepository;
use MyTour\CoreBundle\Utils\GlobalSession;
use MyTour\ExcursionBundle\Entity\Catalog;
use MyTour\ExcursionBundle\Entity\Filter\CatalogFormFilter;
use MyTour\UserBundle\Entity\User;


/**
 * @extends ServiceEntityRepository<User>
 *
 * @method User|null find($id, $lockMode = null, $lockVersion = null, $onlyActive = true)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CatalogRepository extends BaseRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Catalog::class);
    }

    /**
     * @param CatalogFormFilter $catalogFormFilter
     * @return mixed
     */
    public function findByFilter(CatalogFormFilter $catalogFormFilter)
    {
        $qb = $this->findByAbstractFilter($catalogFormFilter);

        $qb->join('entity.organizer', 'organizer');

        $qb
            ->andWhere('organizer.company = :currentCompany')
            ->setParameter('currentCompany', GlobalSession::getCurrentCompany());

        if ($catalogFormFilter->getTitle()){
            $qb
                ->andWhere('entity.title LIKE :title')
                ->setParameter('title', "%{$catalogFormFilter->getTitle()}%");
        }

        if ($catalogFormFilter->getDescription()){
            $qb
                ->andWhere('entity.description LIKE :description')
                ->setParameter('description', "%{$catalogFormFilter->getDescription()}%");
        }

        if (!is_null($catalogFormFilter->getAvailable())){
            $qb
                ->andWhere($qb->expr()->eq('entity.available', ':available'))
                ->setParameter('available', $catalogFormFilter->getAvailable());
        }

        if ($catalogFormFilter->getPrice()){
            $qb
                ->andWhere('entity.price = :price')
                ->setParameter('price', $catalogFormFilter->getPrice());
        }

        if ($catalogFormFilter->getOrganizer()){
            $qb
                ->andWhere($qb->expr()->eq('entity.organizer', ':organizer'))
                ->setParameter('organizer', $catalogFormFilter->getOrganizer());
        }

        return $qb
            ->orderBy('entity.title', 'ASC')
            ->getQuery();
    }
}