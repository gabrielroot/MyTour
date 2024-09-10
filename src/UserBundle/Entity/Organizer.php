<?php

namespace MyTour\UserBundle\Entity;

use MyTour\CoreBundle\Interface\IAudit;
use MyTour\UserBundle\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: 'organizer_users')]
class Organizer extends User implements IAudit
{
    public function __construct()
    {
        parent::__construct();
    }
}