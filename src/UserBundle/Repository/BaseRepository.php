<?php

namespace MyTour\UserBundle\Repository;

use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;
use MyTour\CoreBundle\Entity\Filter\AbstractFormFilter;
use MyTour\CoreBundle\Interface\IAudit;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @extends ServiceEntityRepository<IAudit>
 */
abstract class BaseRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, $className)
    {
        parent::__construct($registry, $className);
    }

    public function save(IAudit|UserInterface $entity, bool $flush = true): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function deleteNow(IAudit $entity, bool $flush = true): void
    {
        $entity->setDeletedAt(new DateTime());
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function reactivate(IAudit $entity): void
    {
        $entity->setDeletedAt(null);
        $this->getEntityManager()->persist($entity);
        $this->getEntityManager()->flush();
    }

    public function find(mixed $id, mixed $lockMode = null, $lockVersion = null): ?IAudit
    {
        $qb = $this->newCriteriaActiveQb();

        return $qb
            ->andWhere($qb->expr()->eq('entity.id', ':id'))
            ->setParameter(key: 'id', value: $id)
            ->getQuery()
            ->setMaxResults(1)
            ->getOneOrNullResult();
    }

    public function findOneBy(array $criteria, array $orderBy = null): ?IAudit
    {
        $qb = $this->newCriteriaActiveQb();

        $this->addCriteriaAndOrder($qb, $criteria, $orderBy ?? []);

        return $qb
            ->getQuery()
            ->setMaxResults(1)
            ->getOneOrNullResult();
    }

    public function findBy(array $criteria, array $orderBy = null, ?int $limit = null, ?int $offset = 0): array
    {
        $qb = $this->newCriteriaActiveQb();

        $this->addCriteriaAndOrder($qb, $criteria, $orderBy ?? []);

        return $qb
            ->getQuery()
            ->setMaxResults($limit)
            ->setFirstResult($offset)
            ->getResult();
    }

    public function findAll(): array
    {
        return $this
            ->newCriteriaActiveQb()
            ->getQuery()
            ->getResult();
    }

    public function newCriteriaActiveQb(): QueryBuilder
    {
        $qb = $this->createQueryBuilder('entity');
        return $qb->where($qb->expr()->isNull('entity.deletedAt'));
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

    /**
     * @param AbstractFormFilter $abstractFormFilter
     * @return QueryBuilder
     */
    public function findByAbstractFilter(AbstractFormFilter $abstractFormFilter): QueryBuilder
    {
        $qb = $this->createQueryBuilder('entity');

        if (!is_null($abstractFormFilter->getActive())) {
            if ($abstractFormFilter->getActive()) {
                $qb->where($qb->expr()->isNull('entity.deletedAt'));
            } else {
                $qb->where($qb->expr()->isNotNull('entity.deletedAt'));
            }
        }

        //START USERS
        if ($abstractFormFilter->getCreatedBy()) {
            $qb
                ->where('entity.createdBy = :createdBy')
                ->setParameter('createdBy', $abstractFormFilter->getCreatedBy());
        }

        if ($abstractFormFilter->getUpdatedBy()) {
            $qb
                ->where('entity.updatedBy = :updatedBy')
                ->setParameter('updatedBy', $abstractFormFilter->getUpdatedBy());
        }

        if ($abstractFormFilter->getDeletedBy()) {
            $qb
                ->where('entity.deletedBy = :deletedBy')
                ->setParameter('deletedBy', $abstractFormFilter->getDeletedBy());
        }
        //END USERS

        //START TIMESTAMPS
        if ($abstractFormFilter->getCreatedAtStart()){
            $qb
                ->andWhere($qb->expr()->gte('entity.createdAt', ':createdAtStart'))
                ->setParameter('createdAtStart', $abstractFormFilter->getCreatedAtStart());
        }

        if ($abstractFormFilter->getCreatedAtEnd()){
            $qb
                ->andWhere($qb->expr()->lte('entity.createdAt', ':createdAtEnd'))
                ->setParameter('createdAtEnd', $abstractFormFilter->getCreatedAtEnd());
        }

        if ($abstractFormFilter->getUpdatedAtStart()){
            $qb
                ->andWhere($qb->expr()->gte('entity.updatedAt', ':updatedAtStart'))
                ->setParameter('updatedAtStart', $abstractFormFilter->getUpdatedAtStart());
        }

        if ($abstractFormFilter->getUpdatedAtEnd()){
            $qb
                ->andWhere($qb->expr()->lte('entity.updatedAt', ':updatedAtEnd'))
                ->setParameter('updatedAtEnd', $abstractFormFilter->getUpdatedAtEnd());
        }

        if ($abstractFormFilter->getDeletedAtStart()){
            $qb
                ->andWhere($qb->expr()->gte('entity.deletedAt', ':deletedAtStart'))
                ->setParameter('deletedAtStart', $abstractFormFilter->getDeletedAtStart());
        }

        if ($abstractFormFilter->getDeletedAtEnd()){
            $qb
                ->andWhere($qb->expr()->lte('entity.deletedAt', ':deletedAtEnd'))
                ->setParameter('deletedAtEnd', $abstractFormFilter->getDeletedAtEnd());
        }
        //END TIMESTAMPS

        return $qb;
    }
}