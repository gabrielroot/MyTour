<?php

namespace MyTour\CoreBundle\Entity\Filter;

use DateTime;
use MyTour\UserBundle\Entity\User;

abstract class AbstractFormFilter
{
    private ?User $createdBy = null;

    private ?User $updatedBy = null;

    private ?User $deletedBy = null;

    private ?DateTime $createdAtStart = null;
    private ?DateTime $createdAtEnd = null;

    private ?DateTime $updatedAtStart = null;
    private ?DateTime $updatedAtEnd = null;

    private ?DateTime $deletedAtStart = null;
    private ?DateTime $deletedAtEnd = null;

    private ?int $active;

    private ?int $perPage;

    public function __construct()
    {
        $this->active = 1;
        $this->perPage = 20;
    }

    public function getCreatedBy(): ?User
    {
        return $this->createdBy;
    }

    public function setCreatedBy(?User $createdBy): AbstractFormFilter
    {
        $this->createdBy = $createdBy;
        return $this;
    }

    public function getUpdatedBy(): ?User
    {
        return $this->updatedBy;
    }

    public function setUpdatedBy(?User $updatedBy): AbstractFormFilter
    {
        $this->updatedBy = $updatedBy;
        return $this;
    }

    public function getDeletedBy(): ?User
    {
        return $this->deletedBy;
    }

    public function setDeletedBy(?User $deletedBy): AbstractFormFilter
    {
        $this->deletedBy = $deletedBy;
        return $this;
    }

    public function getCreatedAtStart(): ?DateTime
    {
        return $this->createdAtStart;
    }

    public function setCreatedAtStart(?DateTime $createdAtStart): AbstractFormFilter
    {
        $this->createdAtStart = $createdAtStart;
        return $this;
    }

    public function getCreatedAtEnd(): ?DateTime
    {
        return $this->createdAtEnd;
    }

    public function setCreatedAtEnd(?DateTime $createdAtEnd): AbstractFormFilter
    {
        $this->createdAtEnd = $createdAtEnd;
        return $this;
    }

    public function getUpdatedAtStart(): ?DateTime
    {
        return $this->updatedAtStart;
    }

    public function setUpdatedAtStart(?DateTime $updatedAtStart): AbstractFormFilter
    {
        $this->updatedAtStart = $updatedAtStart;
        return $this;
    }

    public function getUpdatedAtEnd(): ?DateTime
    {
        return $this->updatedAtEnd;
    }

    public function setUpdatedAtEnd(?DateTime $updatedAtEnd): AbstractFormFilter
    {
        $this->updatedAtEnd = $updatedAtEnd;
        return $this;
    }

    public function getDeletedAtStart(): ?DateTime
    {
        return $this->deletedAtStart;
    }

    public function setDeletedAtStart(?DateTime $deletedAtStart): AbstractFormFilter
    {
        $this->deletedAtStart = $deletedAtStart;
        return $this;
    }

    public function getDeletedAtEnd(): ?DateTime
    {
        return $this->deletedAtEnd;
    }

    public function setDeletedAtEnd(?DateTime $deletedAtEnd): AbstractFormFilter
    {
        $this->deletedAtEnd = $deletedAtEnd;
        return $this;
    }

    public function getActive(): ?int
    {
        return $this->active;
    }

    public function setActive(?int $active): AbstractFormFilter
    {
        $this->active = $active;
        return $this;
    }

    public function getPerPage(): ?int
    {
        return $this->perPage;
    }

    public function setPerPage(?int $perPage): AbstractFormFilter
    {
        $this->perPage = $perPage;
        return $this;
    }

}