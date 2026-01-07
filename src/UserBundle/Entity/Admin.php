<?php

namespace MyTour\UserBundle\Entity;

use MyTour\CoreBundle\Interface\IAudit;
use MyTour\UserBundle\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: 'admin_users')]
class Admin extends User implements IAudit
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getType(): string
    {
        return self::class;
    }
}