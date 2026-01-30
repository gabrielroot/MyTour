<?php

namespace MyTour\UserBundle\Service;

use MyTour\UserBundle\Repository\UserRepository;
use MyTour\UserBundle\Repository\OrganizerRepository;
use MyTour\UserBundle\Repository\TravelerRepository;
use Doctrine\ORM\EntityManagerInterface;

class UserStatsService
{
    private UserRepository $userRepository;
    private OrganizerRepository $organizerRepository;
    private TravelerRepository $travelerRepository;
    private EntityManagerInterface $em;

    public function __construct(
        UserRepository $userRepository,
        OrganizerRepository $organizerRepository,
        TravelerRepository $travelerRepository,
        EntityManagerInterface $em
    ) {
        $this->userRepository = $userRepository;
        $this->organizerRepository = $organizerRepository;
        $this->travelerRepository = $travelerRepository;
        $this->em = $em;
    }

    public function getUserStats(): array
    {
        $userCount = $this->userRepository->countAllUsers();
        $organizerCount = $this->organizerRepository->countAllOrganizers();
        $travelerCount = $this->travelerRepository->countAllTravelers();
        $adminCount = (int) $this->em->createQueryBuilder()
            ->select('COUNT(a.id)')
            ->from('MyTour\\UserBundle\\Entity\\Admin', 'a')
            ->getQuery()
            ->getSingleScalarResult();

        return [
            'userCount' => $userCount,
            'organizerCount' => $organizerCount,
            'travelerCount' => $travelerCount,
            'adminCount' => $adminCount,
        ];
    }
}
