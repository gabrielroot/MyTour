<?php

namespace MyTour\CoreBundle\Utils\Trait;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use MyTour\UserBundle\Entity\User;

trait AuditTrait
{
    #[ORM\Column(type: 'datetime', options: ['default' => 'CURRENT_TIMESTAMP'])]
    protected DateTime $createdAt;

    #[ORM\Column(type: 'datetime', nullable: true)]
    protected ?DateTime $updatedAt = null;

    #[ORM\Column(type: 'datetime', nullable: true)]
    protected ?DateTime $deletedAt = null;

    #[ORM\ManyToOne(targetEntity: User::class)]
    protected ?User $createdBy = null;

    #[ORM\ManyToOne(targetEntity: User::class)]
    protected ?User $updatedBy = null;

    #[ORM\ManyToOne(targetEntity: User::class)]
    protected ?User $deletedBy = null;

    #[ORM\Column(type: 'datetime', nullable: true)]
    protected ?DateTime $lastLogin = null;

    public function __construct()
    {
        $this->createdAt = new DateTime();
    }

    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function getUpdatedAt(): ?DateTime
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?DateTime $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    public function getDeletedAt(): ?DateTime
    {
        return $this->deletedAt;
    }

    public function setDeletedAt(?DateTime $deletedAt): void
    {
        $this->deletedAt = $deletedAt;
    }

    public function getCreatedBy(): ?User
    {
        return $this->createdBy;
    }

    public function setCreatedBy(?User $createdBy): void
    {
        $this->createdBy = $createdBy;
    }

    public function getUpdatedBy(): ?User
    {
        return $this->updatedBy;
    }

    public function setUpdatedBy(?User $updatedBy): void
    {
        $this->updatedBy = $updatedBy;
    }

    public function getDeletedBy(): ?User
    {
        return $this->deletedBy;
    }

    public function setDeletedBy(?User $deletedBy): void
    {
        $this->deletedBy = $deletedBy;
    }

    public function isDeleted(): bool
    {
        return !is_null($this->deletedAt);
    }

    public function getLastLogin(): ?DateTime
    {
        return $this->lastLogin;
    }

    public function setLastLogin(?DateTime $lastLogin): void
    {
        $this->lastLogin = $lastLogin;
    }
}