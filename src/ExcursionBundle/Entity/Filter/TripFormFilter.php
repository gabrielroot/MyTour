<?php

namespace MyTour\ExcursionBundle\Entity\Filter;

use Doctrine\Common\Collections\Collection;
use MyTour\CoreBundle\Entity\Filter\AbstractFormFilter;
use MyTour\UserBundle\Entity\Organizer;
use MyTour\UserBundle\Entity\Traveler;

class TripFormFilter extends AbstractFormFilter
{
    private ?string $title = null;

    private ?string $description = null;

    private ?string $capacity = null;

    private ?Traveler $traveler = null;

    private ?bool $available = null;

    private ?float $price = null;

    private ?float $dateStart = null;

    private ?float $dateEnd = null;

    private ?Collection $checkpoints = null;

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): TripFormFilter
    {
        $this->title = $title;
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): TripFormFilter
    {
        $this->description = $description;
        return $this;
    }

    public function getTraveler(): ?Traveler
    {
        return $this->traveler;
    }

    public function setTraveler(?Traveler $traveler): TripFormFilter
    {
        $this->traveler = $traveler;
        return $this;
    }

    public function getAvailable(): ?bool
    {
        return $this->available;
    }

    public function setAvailable(?bool $available): TripFormFilter
    {
        $this->available = $available;
        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(?float $price): TripFormFilter
    {
        $this->price = $price;
        return $this;
    }

    public function getCapacity(): ?string
    {
        return $this->capacity;
    }

    public function setCapacity(?string $capacity): TripFormFilter
    {
        $this->capacity = $capacity;
        return $this;
    }

    public function getDateStart(): ?float
    {
        return $this->dateStart;
    }

    public function setDateStart(?float $dateStart): TripFormFilter
    {
        $this->dateStart = $dateStart;
        return $this;
    }

    public function getDateEnd(): ?float
    {
        return $this->dateEnd;
    }

    public function setDateEnd(?float $dateEnd): TripFormFilter
    {
        $this->dateEnd = $dateEnd;
        return $this;
    }

    public function getCheckpoints(): Collection
    {
        return $this->checkpoints;
    }

    public function setCheckpoints(?Collection $checkpoints): TripFormFilter
    {
        $this->checkpoints = $checkpoints;
        return $this;
    }
}