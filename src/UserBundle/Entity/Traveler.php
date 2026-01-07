<?php

namespace MyTour\UserBundle\Entity;

use Doctrine\Common\Collections\Collection;
use MyTour\CoreBundle\Interface\IAudit;
use MyTour\ExcursionBundle\Entity\Trip;
use MyTour\UserBundle\Repository\TravelerRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TravelerRepository::class)]
#[ORM\Table(name: 'traveler_users')]
class Traveler extends User implements IAudit
{
    #[ORM\OneToMany(targetEntity: Trip::class, mappedBy: 'traveler')]
    private Collection $trips;

    public function __construct()
    {
        parent::__construct();
    }

    public function getTrips(): Collection
    {
        return $this->trips;
    }
    public function setTrips(Collection $trips): Traveler
    {
        $this->trips = $trips;
        return $this;
    }
}