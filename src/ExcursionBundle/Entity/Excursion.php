<?php

namespace MyTour\ExcursionBundle\Entity;

class Excursion
{
    private string $title;
    private string $description;
    private int $capacity;
    private \DateTime $dateStart;
    private \DateTime $dateEnd;
    private bool $available;
    private float $price;

    public function __construct() {
        $this->available = true;
        $this->dateStart = new \DateTime();
        $this->dateEnd = new \DateTime();
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): Excursion
    {
        $this->title = $title;
        return $this;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): Excursion
    {
        $this->description = $description;
        return $this;
    }

    public function getCapacity(): int
    {
        return $this->capacity;
    }

    public function setCapacity(int $capacity): Excursion
    {
        $this->capacity = $capacity;
        return $this;
    }

    public function getDateStart(): \DateTime
    {
        return $this->dateStart;
    }

    public function setDateStart(\DateTime $dateStart): Excursion
    {
        $this->dateStart = $dateStart;
        return $this;
    }

    public function getDateEnd(): \DateTime
    {
        return $this->dateEnd;
    }

    public function setDateEnd(\DateTime $dateEnd): Excursion
    {
        $this->dateEnd = $dateEnd;
        return $this;
    }

    public function isAvailable(): bool
    {
        return $this->available;
    }

    public function setAvailable(bool $available): Excursion
    {
        $this->available = $available;
        return $this;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function setPrice(float $price): Excursion
    {
        $this->price = $price;
        return $this;
    }
}