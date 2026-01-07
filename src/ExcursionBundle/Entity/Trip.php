<?php

namespace MyTour\ExcursionBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use MyTour\CoreBundle\Utils\Trait\AuditTrait;
use MyTour\ExcursionBundle\Repository\CatalogRepository;
use MyTour\ExcursionBundle\Repository\TripRepository;
use MyTour\UserBundle\Entity\Traveler;

#[ORM\Entity(repositoryClass: TripRepository::class)]
#[ORM\Table(name: 'trips')]
class Trip
{
    use AuditTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 255)]
    private string $title;

    #[ORM\Column(type: 'text', nullable: true)]
    private string $description;

    #[ORM\Column(type: 'integer')]
    private int $capacity;

    #[ORM\Column(type: 'datetime')]
    private \DateTime $dateStart;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private \DateTime $dateEnd;

    #[ORM\Column(type: 'float')]
    private float $price;

    #[ORM\ManyToOne(targetEntity: Traveler::class, inversedBy: 'trips')]
    private Traveler $traveler;

    public function __construct() {
        $this->dateStart = new \DateTime();
        $this->dateEnd = new \DateTime();
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): Trip
    {
        $this->title = $title;
        return $this;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): Trip
    {
        $this->description = $description;
        return $this;
    }

    public function getCapacity(): int
    {
        return $this->capacity;
    }

    public function setCapacity(int $capacity): Trip
    {
        $this->capacity = $capacity;
        return $this;
    }

    public function getDateStart(): \DateTime
    {
        return $this->dateStart;
    }

    public function setDateStart(\DateTime $dateStart): Trip
    {
        $this->dateStart = $dateStart;
        return $this;
    }

    public function getDateEnd(): \DateTime
    {
        return $this->dateEnd;
    }

    public function setDateEnd(\DateTime $dateEnd): Trip
    {
        $this->dateEnd = $dateEnd;
        return $this;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function setPrice(float $price): Trip
    {
        $this->price = $price;
        return $this;
    }

    public function getTraveler(): Traveler
    {
        return $this->traveler;
    }

    public function setTraveler(Traveler $traveler): Trip
    {
        $this->traveler = $traveler;
        return $this;
    }
}