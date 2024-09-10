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

    public function getCreatedAtStart(): ?string
    {
        return $this->getFormatedDateTime($this->createdAtStart);
    }

    public function setCreatedAtStart(mixed $createdAtStart): AbstractFormFilter
    {
        $this->createdAtStart = $this->getDateTimeFromMixed($createdAtStart);
        return $this;
    }

    public function getCreatedAtEnd(): ?string
    {
        return $this->getFormatedDateTime($this->createdAtEnd);
    }

    public function setCreatedAtEnd(mixed $createdAtEnd): AbstractFormFilter
    {
        $this->createdAtEnd = $this->getDateTimeFromMixed($createdAtEnd);
        return $this;
    }

    public function getUpdatedAtStart(): ?string
    {
        return $this->getFormatedDateTime($this->updatedAtStart);
    }

    public function setUpdatedAtStart(mixed $updatedAtStart): AbstractFormFilter
    {
        $this->updatedAtStart = $this->getDateTimeFromMixed($updatedAtStart);
        return $this;
    }

    public function getUpdatedAtEnd(): ?string
    {
        return $this->getFormatedDateTime($this->updatedAtEnd);
    }

    public function setUpdatedAtEnd(mixed $updatedAtEnd): AbstractFormFilter
    {
        $this->updatedAtEnd = $this->getDateTimeFromMixed($updatedAtEnd);
        return $this;
    }

    public function getDeletedAtStart(): ?string
    {
        return $this->getFormatedDateTime($this->deletedAtStart);
    }

    public function setDeletedAtStart(mixed $deletedAtStart): AbstractFormFilter
    {
        $this->deletedAtStart = $this->getDateTimeFromMixed($deletedAtStart);
        return $this;
    }

    public function getDeletedAtEnd(): ?string
    {
        return $this->getFormatedDateTime($this->deletedAtEnd);
    }

    public function setDeletedAtEnd(mixed $deletedAtEnd): AbstractFormFilter
    {
        $this->deletedAtEnd = $this->getDateTimeFromMixed($deletedAtEnd);
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

    /**
     * @param DateTime|null $dateTime
     * @return string|null
     */
    public function getFormatedDateTime(?Datetime $dateTime, bool $justDate = false): ?string
    {
        return $dateTime?->format('Y-m-d' . ($justDate ? '' : ' H:i:s'));
    }

    public function getDateTimeFromMixed(mixed $dateTime): ?DateTime
    {
        if ($dateTime instanceof DateTime) {
            return $dateTime;
        }

        if (is_string($dateTime)) {
            return DateTime::createFromFormat((strlen($dateTime) === 10) ? 'd/m/Y' : 'd/m/Y H:i', $dateTime);
        }

        return null;
    }
}