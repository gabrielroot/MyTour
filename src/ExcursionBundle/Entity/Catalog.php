<?php

namespace MyTour\ExcursionBundle\Entity;

use MyTour\CoreBundle\Interface\IAudit;
use MyTour\CoreBundle\Utils\Trait\AuditTrait;
use MyTour\ExcursionBundle\Repository\CatalogRepository;
use Doctrine\ORM\Mapping as ORM;
use MyTour\UserBundle\Entity\Organizer;

#[ORM\Entity(repositoryClass: CatalogRepository::class)]
#[ORM\Table(name: 'catalogs')]
class Catalog implements IAudit
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

    #[ORM\Column(type: 'boolean', options: ['default' => true])]
    private bool $available;

    #[ORM\Column(type: 'float')]
    private float $price;

    #[ORM\ManyToOne(targetEntity: Organizer::class, inversedBy: 'catalogs')]
    private Organizer $organizer;

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

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): Catalog
    {
        $this->id = $id;
        return $this;
    }

    public function getOrganizer(): Organizer
    {
        return $this->organizer;
    }

    public function setOrganizer(Organizer $organizer): Catalog
    {
        $this->organizer = $organizer;
        return $this;
    }
}