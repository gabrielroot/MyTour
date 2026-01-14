<?php

namespace MyTour\ExcursionBundle\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use MyTour\CoreBundle\Interface\IAudit;
use MyTour\CoreBundle\Utils\Trait\AuditTrait;
use MyTour\ExcursionBundle\Repository\CatalogRepository;
use MyTour\ExcursionBundle\Repository\TripRepository;
use MyTour\UserBundle\Entity\Traveler;

#[ORM\Entity(repositoryClass: TripRepository::class)]
#[ORM\Table(name: 'trips')]
class Trip implements IAudit
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

    #[ORM\Column(type: 'integer')]
    private int $capacity;

    #[ORM\Column(type: 'datetime')]
    private \DateTime $dateStart;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private \DateTime $dateEnd;

    #[ORM\Column(type: 'float')]
    private float $price;

    #[ORM\ManyToOne(targetEntity: Traveler::class, inversedBy: 'trips')]
    private Traveler $traveler;//TODO: N to N relationship

    #[ORM\ManyToOne(targetEntity: Catalog::class, inversedBy: 'trips')]
    private Catalog $catalog;

    #[ORM\OneToMany(targetEntity: Checkpoint::class, mappedBy: 'checkpoints')]
    private Collection $checkpoints;

    public function __construct() {
        $this->checkpoints = new ArrayCollection();
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

    public function getDescription(): ?string
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

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): Trip
    {
        $this->id = $id;
        return $this;
    }

    public function getCatalog(): Catalog
    {
        return $this->catalog;
    }

    public function setCatalog(Catalog $catalog): Trip
    {
        $this->catalog = $catalog;
        return $this;
    }

    public function getCheckpoints(): Collection
    {
        return $this->checkpoints;
    }

    public function setCheckpoints(Collection $checkpoints): Trip
    {
        $this->checkpoints = $checkpoints;
        return $this;
    }
}