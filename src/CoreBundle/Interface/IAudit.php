<?php

namespace MyTour\CoreBundle\Interface;

use DateTime;
use MyTour\UserBundle\Entity\User;

interface IAudit
{
    public function getCreatedAt() : ?DateTime;

    public function setCreatedAt(DateTime $createdAt): self;

    public function getUpdatedAt(): ?DateTime;

    public function setUpdatedAt(?DateTime $updatedAt): self;

    public function getDeletedAt(): ?DateTime;

    public function setDeletedAt(?DateTime $deletedAt): self;

    public function getCreatedBy(): ?User;

    public function setCreatedBy(?User $createdBy): self;

    public function getUpdatedBy(): ?User;

    public function setUpdatedBy(?User $updatedBy): self;

    public function getDeletedBy(): ?User;

    public function setDeletedBy(?User $deletedBy): self;

    public function isActive(): bool;
}