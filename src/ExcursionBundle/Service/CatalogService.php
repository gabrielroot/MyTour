<?php

namespace MyTour\ExcursionBundle\Service;

use Exception;
use MyTour\CoreBundle\Utils\GlobalSession;
use MyTour\ExcursionBundle\Entity\Catalog;
use MyTour\ExcursionBundle\Entity\Filter\CatalogFormFilter;
use MyTour\ExcursionBundle\Repository\CatalogRepository;
use MyTour\UserBundle\Entity\Organizer;
use MyTour\UserBundle\Repository\OrganizerRepository;

class CatalogService
{
    public function __construct(
        private readonly CatalogRepository $catalogRepository,
        private readonly OrganizerRepository $organizerRepository)
    {

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
        if(!$organizer = $this->organizerRepository->find(GlobalSession::getLoggedInUser()->getId())) {
            throw new Exception("Apenas organizadores podem criar catálogos.");
        }

        $catalog->setOrganizer($organizer);
        $this->catalogRepository->save(entity: $catalog, flush: $flush);
    }

    public function updateCatalog(Catalog $catalog, bool $flush = true): void
    {
        $this->catalogRepository->save(entity: $catalog, flush: $flush);
    }

    public function deleteCatalog(Catalog $catalog, bool $flush = true): void
    {
        $this->catalogRepository->deleteNow($catalog, $flush);
    }

    /**
     * @throws Exception
     */
    public function reactivateCatalog(int $id, bool $flush = true): void
    {
        $userFound = $this->catalogRepository->find($id, onlyActive: false);

        if(!$userFound) {
            throw new Exception('Catálogo não encontrado.');
        }

        $this->catalogRepository->reactivate(entity: $userFound, flush: $flush);
    }
}