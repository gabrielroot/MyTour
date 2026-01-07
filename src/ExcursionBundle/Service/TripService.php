<?php

namespace MyTour\ExcursionBundle\Service;

use Exception;
use MyTour\CoreBundle\Utils\GlobalSession;
use MyTour\ExcursionBundle\Entity\Catalog;
use MyTour\ExcursionBundle\Entity\Filter\TripFormFilter;
use MyTour\ExcursionBundle\Repository\CatalogRepository;
use MyTour\ExcursionBundle\Repository\TripRepository;
use MyTour\UserBundle\Entity\Organizer;
use MyTour\UserBundle\Repository\OrganizerRepository;
use MyTour\UserBundle\Repository\TravelerRepository;

class TripService
{
    public function __construct(
        private readonly TripRepository $tripRepository,
        private readonly TravelerRepository $travelerRepository)
    {

    }


    /**
     * @param TripFormFilter $catalogFormFilter
     * @return mixed
     */
    public function findByFilter(TripFormFilter $catalogFormFilter): mixed
    {

        return $this->tripRepository->findByFilter($catalogFormFilter);
    }

    public function createCatalog(Catalog $catalog, bool $flush = true): void
    {
        if(!$organizer = $this->travelerRepository->find(GlobalSession::getLoggedInUser()->getId())) {
            throw new Exception("Apenas organizadores podem criar catálogos.");
        }

        $catalog->setOrganizer($organizer);
        $this->tripRepository->save(entity: $catalog, flush: $flush);
    }

    public function updateCatalog(Catalog $catalog, bool $flush = true): void
    {
        $this->tripRepository->save(entity: $catalog, flush: $flush);
    }

    public function deleteCatalog(Catalog $catalog, bool $flush = true): void
    {
        $this->tripRepository->deleteNow($catalog, $flush);
    }

    /**
     * @throws Exception
     */
    public function reactivateCatalog(int $id, bool $flush = true): void
    {
        $userFound = $this->tripRepository->find($id, onlyActive: false);

        if(!$userFound) {
            throw new Exception('Catálogo não encontrado.');
        }

        $this->tripRepository->reactivate(entity: $userFound, flush: $flush);
    }
}