<?php

namespace MyTour\CoreBundle\Service;

use Exception;
use MyTour\CoreBundle\Entity\Company;
use MyTour\CoreBundle\Entity\Filter\CompanyFormFilter;
use MyTour\CoreBundle\Repository\CompanyRepository;

class CompanyService
{
    private CompanyRepository $companyRepository;

    public function __construct(CompanyRepository $companyRepository)
    {
        $this->companyRepository = $companyRepository;
    }


    /**
     * @param CompanyFormFilter $companyFilter
     * @return mixed
     */
    public function findByFilter(CompanyFormFilter $companyFilter): mixed
    {

        return $this->companyRepository->findByFilter($companyFilter);
    }

    public function createCompany(Company $company, bool $flush = true): void
    {
        $this->companyRepository->save(entity: $company, flush: $flush);
    }

    public function updateCompany(Company $company, bool $flush = true): void
    {
        $this->companyRepository->save(entity: $company, flush: $flush);
    }

    public function deleteCompany(Company $company, bool $flush = true): void
    {
        $this->companyRepository->deleteNow($company, $flush);
    }

    /**
     * @throws Exception
     */
    public function reactivateCompany(int $id, bool $flush = true): void
    {
        $companyFound = $this->companyRepository->find($id,  onlyActive: false);

        if(!$companyFound) {
            throw new Exception('Empresa não encontrada.');
        }

        $this->companyRepository->reactivate(entity: $companyFound, flush: $flush);
    }
}