<?php

namespace MyTour\ExcursionBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use MyTour\CoreBundle\Interface\IAudit;
use MyTour\CoreBundle\Utils\Trait\AuditTrait;
use MyTour\ExcursionBundle\Repository\CatalogRepository;
use MyTour\ExcursionBundle\Repository\CheckpointRepository;
use MyTour\ExcursionBundle\Repository\TripRepository;
use MyTour\UserBundle\Entity\Traveler;

#[ORM\Entity(repositoryClass: CheckpointRepository::class)]
#[ORM\Table(name: 'checkpoints')]
class Checkpoint implements IAudit
{
    use AuditTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 255)]
    private string $title;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $description;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private ?\DateTime $visitedDateTime;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private ?\DateTime $estimatedDateTime;

    #[ORM\Column(type: 'string', length: 255)]
    private string $location;

    #[ORM\Column(type: 'float')]
    private float $latitude;

    #[ORM\Column(type: 'float')]
    private float $longitude;

    #[ORM\ManyToOne(targetEntity: Trip::class, inversedBy: 'checkpoints')]
    private Trip $trip;

    public function __construct() {
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): Checkpoint
    {
        $this->id = $id;
        return $this;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): Checkpoint
    {
        $this->title = $title;
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): Checkpoint
    {
        $this->description = $description;
        return $this;
    }

    public function getVisitedDateTime(): ?\DateTime
    {
        return $this->visitedDateTime;
    }

    public function setVisitedDateTime(?\DateTime $visitedDateTime): Checkpoint
    {
        $this->visitedDateTime = $visitedDateTime;
        return $this;
    }

    public function getEstimatedDateTime(): ?\DateTime
    {
        return $this->estimatedDateTime;
    }

    public function setEstimatedDateTime(?\DateTime $estimatedDateTime): Checkpoint
    {
        $this->estimatedDateTime = $estimatedDateTime;
        return $this;
    }

    public function getLocation(): string
    {
        return $this->location;
    }

    public function setLocation(string $location): Checkpoint
    {
        $this->location = $location;
        return $this;
    }

    public function getLatitude(): float
    {
        return $this->latitude;
    }

    public function setLatitude(float $latitude): Checkpoint
    {
        $this->latitude = $latitude;
        return $this;
    }

    public function getLongitude(): float
    {
        return $this->longitude;
    }

    public function setLongitude(float $longitude): Checkpoint
    {
        $this->longitude = $longitude;
        return $this;
    }

    public function getTrip(): Trip
    {
        return $this->trip;
    }

    public function setTrip(Trip $trip): Checkpoint
    {
        $this->trip = $trip;
        return $this;
    }
}