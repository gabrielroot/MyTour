<?php

namespace MyTour\ExcursionBundle\Service;

use Exception;
use MyTour\CoreBundle\Utils\GlobalSession;
use MyTour\ExcursionBundle\Entity\Checkpoint;
use MyTour\ExcursionBundle\Entity\Filter\CheckpointFormFilter;
use MyTour\ExcursionBundle\Repository\CheckpointRepository;
use MyTour\UserBundle\Repository\OrganizerRepository;

class CheckpointService
{
    public function __construct(
        private readonly CheckpointRepository $checkpointRepository,
        private readonly OrganizerRepository $organizerRepository)
    {

    }


    /**
     * @param CheckpointFormFilter $checkpointFormFilter
     * @return mixed
     */
    public function findByFilter(CheckpointFormFilter $checkpointFormFilter): mixed
    {
        return $this->checkpointRepository->findByFilter($checkpointFormFilter);
    }

    public function createCheckpoint(Checkpoint $checkpoint, bool $flush = true): void
    {
        if(!$this->organizerRepository->find(GlobalSession::getLoggedInUser()->getId())) {
            throw new Exception("Apenas organizadores podem criar checkpoints.");
        }

        $this->checkpointRepository->save(entity: $checkpoint, flush: $flush);
    }

    public function updateCheckpoint(Checkpoint $checkpoint, bool $flush = true): void
    {
        $this->checkpointRepository->save(entity: $checkpoint, flush: $flush);
    }

    public function deleteCheckpoint(Checkpoint $checkpoint, bool $flush = true): void
    {
        $this->checkpointRepository->deleteNow($checkpoint, $flush);
    }

    /**
     * @throws Exception
     */
    public function reactivateCheckpoint(int $id, bool $flush = true): void
    {
        $userFound = $this->checkpointRepository->find($id, onlyActive: false);

        if(!$userFound) {
            throw new Exception('Catálogo não encontrado.');
        }

        $this->checkpointRepository->reactivate(entity: $userFound, flush: $flush);
    }
}