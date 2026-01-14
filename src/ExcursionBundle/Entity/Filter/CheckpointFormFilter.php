<?php

namespace MyTour\ExcursionBundle\Entity\Filter;

use MyTour\CoreBundle\Entity\Filter\AbstractFormFilter;
use MyTour\ExcursionBundle\Entity\Trip;
use MyTour\UserBundle\Entity\Organizer;
use MyTour\UserBundle\Entity\Traveler;

class CheckpointFormFilter extends AbstractFormFilter
{
    private ?string $title = null;

    private ?string $description = null;

    private ?string $location = null;

    private ?Trip $trip = null;

    private ?float $latitude = null;

    private ?float $longitude = null;

    private ?float $estimatedDateTime = null;

    private ?float $visitedDateTime = null;

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): CheckpointFormFilter
    {
        $this->title = $title;
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): CheckpointFormFilter
    {
        $this->description = $description;
        return $this;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(?string $location): CheckpointFormFilter
    {
        $this->location = $location;
        return $this;
    }

    public function getTrip(): ?Trip
    {
        return $this->trip;
    }

    public function setTrip(?Trip $trip): CheckpointFormFilter
    {
        $this->trip = $trip;
        return $this;
    }

    public function getLatitude(): ?float
    {
        return $this->latitude;
    }

    public function setLatitude(?float $latitude): CheckpointFormFilter
    {
        $this->latitude = $latitude;
        return $this;
    }

    public function getLongitude(): ?float
    {
        return $this->longitude;
    }

    public function setLongitude(?float $longitude): CheckpointFormFilter
    {
        $this->longitude = $longitude;
        return $this;
    }

    public function getEstimatedDateTime(): ?float
    {
        return $this->estimatedDateTime;
    }

    public function setEstimatedDateTime(?float $estimatedDateTime): CheckpointFormFilter
    {
        $this->estimatedDateTime = $estimatedDateTime;
        return $this;
    }

    public function getVisitedDateTime(): ?float
    {
        return $this->visitedDateTime;
    }

    public function setVisitedDateTime(?float $visitedDateTime): CheckpointFormFilter
    {
        $this->visitedDateTime = $visitedDateTime;
        return $this;
    }
}