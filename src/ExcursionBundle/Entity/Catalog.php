<?php

namespace MyTour\ExcursionBundle\Entity;

class Catalog
{
    private string $title;
    private string $description;
    private bool $available;
    private float $price;

    public function __construct() {
        $this->available = true;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): Catalog
    {
        $this->title = $title;
        return $this;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): Catalog
    {
        $this->description = $description;
        return $this;
    }

    public function isAvailable(): bool
    {
        return $this->available;
    }

    public function setAvailable(bool $available): Catalog
    {
        $this->available = $available;
        return $this;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function setPrice(float $price): Catalog
    {
        $this->price = $price;
        return $this;
    }
}