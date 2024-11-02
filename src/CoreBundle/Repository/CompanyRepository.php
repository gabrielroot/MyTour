<?php

namespace MyTour\CoreBundle\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use MyTour\CoreBundle\Entity\Company;
use MyTour\CoreBundle\Entity\Filter\CompanyFormFilter;


/**
 * @extends ServiceEntityRepository<Company>
 *
 * @method Company|null find($id, $lockMode = null, $lockVersion = null)
 * @method Company|null findOneBy(array $criteria, array $orderBy = null)
 * @method Company[]    findAll()
 * @method Company[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CompanyRepository extends BaseRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Company::class);
    }

    /**
     * @param CompanyFormFilter $companyFormFilter
     * @return mixed
     */
    public function findByFilter(CompanyFormFilter $companyFormFilter): mixed
    {
        $qb = $this->findByAbstractFilter($companyFormFilter);

        if ($companyFormFilter->getName()){
            $qb
                ->andWhere('entity.name LIKE :name')
                ->setParameter('name', "%{$companyFormFilter->getName()}%");
        }

        if ($companyFormFilter->getFantasyName()){
            $qb
                ->andWhere('entity.fantasyName LIKE :fantasyName')
                ->setParameter('fantasyName', "%{$companyFormFilter->getFantasyName()}%");
        }

        if ($companyFormFilter->getCnpj()){
            $qb
                ->andWhere('entity.cnpj LIKE :cnpj')
                ->setParameter('cnpj', "%{$companyFormFilter->getCnpj()}%");
        }

        return $qb
            ->orderBy('entity.fantasyName', 'ASC')
            ->getQuery();
    }
}