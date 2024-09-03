<?php

namespace MyTour\UserBundle\Service;

use MyTour\UserBundle\Repository\UserRepository;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Security\Core\User\UserInterface;

class UserService
{
    public function __construct(Security $security, UserRepository $userRepository){

    }

    public function createUser(UserInterface $user){

    }
}