<?php

namespace MyTour\UserBundle\Entity\Filter;

use DateTime;
use MyTour\CoreBundle\Entity\Filter\AbstractFormFilter;

class UserFormFilter extends AbstractFormFilter
{
    private ?string $name = null;

    private ?string $username = null;

    private ?Datetime $birthday = null;

    private ?string $role = null;

    public function getRole()
    {
        return $this->role;
    }

    public function setRole( $role): UserFormFilter
    {
        $this->role = $role;
        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(?string $username): UserFormFilter
    {
        $this->username = $username;
        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): UserFormFilter
    {
        $this->name = $name;
        return $this;
    }

    public function getBirthday(): ?DateTime
    {
        return $this->birthday;
    }

    public function setBirthday(?DateTime $birthday): UserFormFilter
    {
        $this->birthday = $birthday;
        return $this;
    }
}