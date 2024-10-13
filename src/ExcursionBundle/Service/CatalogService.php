<?php

namespace MyTour\ExcursionBundle\Service;

use Exception;
use MyTour\ExcursionBundle\Entity\Catalog;
use MyTour\ExcursionBundle\Entity\Filter\CatalogFormFilter;
use MyTour\ExcursionBundle\Repository\CatalogRepository;
use MyTour\UserBundle\Repository\OrganizerRepository;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class CatalogService
{
    private CatalogRepository $catalogRepository;

    public function __construct(CatalogRepository $catalogRepository)
    {
        $this->catalogRepository = $catalogRepository;
    }


    /**
     * @param CatalogFormFilter $catalogFormFilter
     * @return mixed
     */
    public function findByFilter(CatalogFormFilter $catalogFormFilter): mixed
    {

        return $this->catalogRepository->findByFilter($catalogFormFilter);
    }

    public function createCatalog(Catalog $catalog, bool $flush = true): void
    {
        $this->catalogRepository->save(entity: $catalog, flush: $flush);
    }

    public function updateCatalog(Catalog $catalog, bool $flush = true): void
    {
        $this->catalogRepository->save(entity: $catalog, flush: $flush);
    }

    public function deleteCatalog(Catalog $catalog, bool $flush = true): void
    {
        $this->catalogRepository->save(entity: $catalog, flush: $flush);
    }

    /**
     * @throws Exception
     */
    public function reactivateUser(int $id, bool $flush = true): void
    {
        $userFound = $this->catalogRepository->find($id, onlyActive: false);

        if(!$userFound) {
            throw new Exception('Catálogo não encontrado.');
        }

        $this->catalogRepository->reactivate($userFound);
    }
}