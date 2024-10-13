<?php

namespace MyTour\UserBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use MyTour\CoreBundle\Interface\IAudit;
use MyTour\ExcursionBundle\Entity\Catalog;
use MyTour\UserBundle\Repository\OrganizerRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrganizerRepository::class)]
#[ORM\Table(name: 'organizer_users')]
class Organizer extends User implements IAudit
{
    #[ORM\OneToMany(targetEntity: Catalog::class, mappedBy: 'organizer')]
    private Collection $catalogs;

    public function __construct()
    {
        parent::__construct();
        $this->catalogs = new ArrayCollection();
    }

    public function getCatalogs(): Collection
    {
        return $this->catalogs;
    }

    public function setCatalogs(Collection $catalogs): Organizer
    {
        $this->catalogs = $catalogs;
        return $this;
    }

}