<?php

namespace MyTour\ExcursionBundle\Entity\Filter;

use MyTour\CoreBundle\Entity\Filter\AbstractFormFilter;
use MyTour\UserBundle\Entity\Organizer;
use MyTour\UserBundle\Entity\Traveler;

class CatalogFormFilter extends AbstractFormFilter
{
    private ?string $title = null;

    private ?string $description = null;

    private ?Organizer $organizer = null;

    private ?bool $available = null;

    private ?float $price = null;

    private ?int $capacity = null;

    private ?\DateTime $dateStart = null;

    private ?\DateTime $dateEnd = null;

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): CatalogFormFilter
    {
        $this->title = $title;
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): CatalogFormFilter
    {
        $this->description = $description;
        return $this;
    }

    public function getOrganizer(): ?Organizer
    {
        return $this->organizer;
    }

    public function setOrganizer(?Organizer $organizer): CatalogFormFilter
    {
        $this->organizer = $organizer;
        return $this;
    }

    public function getAvailable(): ?bool
    {
        return $this->available;
    }

    public function setAvailable(?bool $available): CatalogFormFilter
    {
        $this->available = $available;
        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(?float $price): CatalogFormFilter
    {
        $this->price = $price;
        return $this;
    }

    public function getCapacity(): ?int
    {
        return $this->capacity;
    }

    public function setCapacity(?int $capacity): CatalogFormFilter
    {
        $this->capacity = $capacity;
        return $this;
    }

    public function getDateStart(): ?\DateTime
    {
        return $this->dateStart;
    }

    public function setDateStart(?\DateTime $dateStart): CatalogFormFilter
    {
        $this->dateStart = $dateStart;
        return $this;
    }

    public function getDateEnd(): ?\DateTime
    {
        return $this->dateEnd;
    }

    public function setDateEnd(?\DateTime $dateEnd): CatalogFormFilter
    {
        $this->dateEnd = $dateEnd;
        return $this;
    }

}