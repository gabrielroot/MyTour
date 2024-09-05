<?php

namespace MyTour\UserBundle\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;
use MyTour\CoreBundle\Interface\IEntity;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @extends ServiceEntityRepository<IEntity>
 */
abstract class BaseRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, $className)
    {
        parent::__construct($registry, $className);
    }

    public function find(mixed $id, mixed $lockMode = null, $lockVersion = null): ?IEntity
    {
        $qb = $this->createQueryBuilder('entity');
        return $qb
            ->where($qb->expr()->isNull('entity.deletedAt'))
            ->andWhere($qb->expr()->eq('entity.id', ':id'))
            ->setParameter(key: 'id', value: $id)
            ->getQuery()
            ->setMaxResults(1)
            ->getOneOrNullResult();
    }

    public function findOneBy(array $criteria, array $orderBy = null): ?IEntity
    {
        $qb = $this->createQueryBuilder('entity');
        $qb->where($qb->expr()->isNull('entity.deletedAt'));

        $this->addCriteriaAndOrder($qb, $criteria, $orderBy ?? []);

        return $qb
            ->getQuery()
            ->setMaxResults(1)
            ->getOneOrNullResult();
    }

    public function findBy(array $criteria, array $orderBy = null, ?int $limit = null, ?int $offset = 0): array
    {
        $qb = $this->createQueryBuilder('entity');
        $qb->where($qb->expr()->isNull('entity.deletedAt'));

        $this->addCriteriaAndOrder($qb, $criteria, $orderBy ?? []);

        return $qb
            ->getQuery()
            ->setMaxResults($limit)
            ->setFirstResult($offset)
            ->getResult();
    }

    public function findAll(): array
    {
        $qb = $this->createQueryBuilder('entity');
        return $qb
            ->where($qb->expr()->isNull('entity.deletedAt'))
            ->getQuery()
            ->getResult();
    }

    public function save(IEntity|UserInterface $entity): void
    {
        $this->getEntityManager()->persist($entity);
        $this->getEntityManager()->flush();
    }

    public function deleteNow(IEntity $entity): void
    {
        $entity->setDeletedAt(new \DateTime());
        $this->getEntityManager()->persist($entity);
        $this->getEntityManager()->flush();
    }

    public function reactivate(IEntity $entity): void
    {
        $entity->setDeletedAt(null);
        $this->getEntityManager()->persist($entity);
        $this->getEntityManager()->flush();
    }

    private function addCriteriaAndOrder(QueryBuilder $qb, array $criteria, array $orderBy): void
    {
        foreach ($criteria as $column => $value) {
            $qb
                ->andWhere("entity.$column = :$column")
                ->setParameter($column, $value);
        }

        foreach ($orderBy as $column => $value) {
            $qb->addOrderBy("entity.$column", $value);
        }
    }
}