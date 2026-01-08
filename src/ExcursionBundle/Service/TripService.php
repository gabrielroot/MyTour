<?php

namespace MyTour\ExcursionBundle\Service;

use Exception;
use MyTour\CoreBundle\Utils\GlobalSession;
use MyTour\ExcursionBundle\Entity\Trip;
use MyTour\ExcursionBundle\Entity\Filter\TripFormFilter;
use MyTour\ExcursionBundle\Repository\TripRepository;
use MyTour\UserBundle\Entity\Organizer;
use MyTour\UserBundle\Repository\OrganizerRepository;
use MyTour\UserBundle\Repository\TravelerRepository;

class TripService
{
    public function __construct(
        private readonly TripRepository     $tripRepository,
        private readonly TravelerRepository $travelerRepository,
        private readonly OrganizerRepository $organizerRepository)
    {

    }


    /**
     * @param TripFormFilter $tripFormFilter
     * @return mixed
     */
    public function findByFilter(TripFormFilter $tripFormFilter): mixed
    {
        return $this->tripRepository->findByFilter($tripFormFilter);
    }

    public function createTrip(Trip $trip, bool $flush = true): void
    {
        if(!$this->organizerRepository->find(GlobalSession::getLoggedInUser()->getId())) {
            throw new Exception("Apenas organizadores podem criar catálogos.");
        }

        $this->tripRepository->save(entity: $trip, flush: $flush);
    }

    public function updateTrip(Trip $trip, bool $flush = true): void
    {
        $this->tripRepository->save(entity: $trip, flush: $flush);
    }

    public function deleteTrip(Trip $trip, bool $flush = true): void
    {
        $this->tripRepository->deleteNow($trip, $flush);
    }

    /**
     * @throws Exception
     */
    public function reactivateTrip(int $id, bool $flush = true): void
    {
        $userFound = $this->tripRepository->find($id, onlyActive: false);

        if(!$userFound) {
            throw new Exception('Catálogo não encontrado.');
        }

        $this->tripRepository->reactivate(entity: $userFound, flush: $flush);
    }
}