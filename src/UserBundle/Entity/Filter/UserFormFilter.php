<?php

namespace MyTour\UserBundle\Entity\Filter;

use MyTour\CoreBundle\Entity\Filter\AbstractFormFilter;
use MyTour\CoreBundle\Utils\Enum\RoleEnum;

class UserFormFilter extends AbstractFormFilter
{
    private ?string $username = null;

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
}