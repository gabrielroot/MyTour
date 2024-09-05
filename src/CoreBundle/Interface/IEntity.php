<?php

namespace MyTour\CoreBundle\Interface;

use DateTime;
use MyTour\UserBundle\Entity\User;

interface IEntity
{
    public function getCreatedAt() : ?DateTime;

    public function setCreatedAt(DateTime $createdAt): void;

    public function getUpdatedAt(): ?DateTime;

    public function setUpdatedAt(?DateTime $updatedAt): void;

    public function getDeletedAt(): ?DateTime;

    public function setDeletedAt(?DateTime $deletedAt): void;

    public function getCreatedBy(): ?User;

    public function setCreatedBy(?User $createdBy): void;

    public function getUpdatedBy(): ?User;

    public function setUpdatedBy(?User $updatedBy): void;

    public function getDeletedBy(): ?User;

    public function setDeletedBy(?User $deletedBy): void;

    public function isDeleted(): bool;

    public function getLastLogin(): ?DateTime;

    public function setLastLogin(?DateTime $lastLogin): void;
}