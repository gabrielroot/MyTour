<?php

namespace MyTour\CoreBundle\Services;

use MyTour\CoreBundle\Interface\IEntity;
use MyTour\UserBundle\Entity\Filter\UserFormFilter;
use MyTour\UserBundle\Entity\User;
use MyTour\UserBundle\Repository\UserRepository;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserService
{
    private UserRepository $userRepository;

    private UserPasswordHasherInterface $hasher;

    public function __construct(
        UserRepository $userRepository,
        UserPasswordHasherInterface $hasher)
    {
        $this->userRepository = $userRepository;
        $this->hasher = $hasher;
    }

    /**
     * @param UserFormFilter $userFormFilter
     * @return mixed
     */
    public function findByFilter(UserFormFilter $userFormFilter){

        return $this->userRepository->findByFilter($userFormFilter);
    }

    public function createUser(User $user, bool $flush = true){
        $user->setPassword($this->hasher->hashPassword($user, $user->getPassword()));
        $this->userRepository->save(entity: $user, flush: $flush);
    }
}