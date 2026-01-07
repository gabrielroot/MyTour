<?php

namespace MyTour\UserBundle\Service;

use Exception;
use MyTour\CoreBundle\Repository\CompanyRepository;
use MyTour\CoreBundle\Utils\Enum\RoleEnum;
use MyTour\CoreBundle\Utils\GlobalSession;
use MyTour\UserBundle\Entity\Filter\UserFormFilter;
use MyTour\UserBundle\Entity\Organizer;
use MyTour\UserBundle\Entity\Traveler;
use MyTour\UserBundle\Entity\User;
use MyTour\UserBundle\Repository\UserRepository;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserService
{
    private UserRepository $userRepository;

    private UserPasswordHasherInterface $hasher;
    private CompanyRepository $companyRepository;

    public function __construct(
        UserRepository              $userRepository,
        CompanyRepository           $companyRepository,
        UserPasswordHasherInterface $hasher)
    {
        $this->userRepository = $userRepository;
        $this->hasher = $hasher;
        $this->companyRepository = $companyRepository;
    }

    /**
     * @param UserFormFilter $userFormFilter
     * @return mixed
     */
    public function findByFilter(UserFormFilter $userFormFilter): mixed
    {

        return $this->userRepository->findByFilter($userFormFilter);
    }

    public function createUser(User $user, bool $flush = true): void
    {
        $user->setPassword($this->hasher->hashPassword($user, $user->getPassword()));

        if ($user instanceof Organizer) {
            $user->setRoles([RoleEnum::ROLE_ORGANIZER->name]);
        } elseif ($user instanceof Traveler) {
            $user->setRoles([RoleEnum::ROLE_TRAVELER->name]);
        }

        if (GlobalSession::getCurrentCompany()) {
            $user->setCompany($this->companyRepository->find(GlobalSession::getCurrentCompany()->getId()));
        }

        $this->userRepository->save(entity: $user, flush: $flush);
    }

    public function updateUser(User $user, User $userBefore, bool $flush = true): void
    {
        if (strlen($user->getPassword())) {
            $user->setPassword($this->hasher->hashPassword($user, $user->getPassword()));
        } else {
            $user->setPassword($userBefore->getPassword());
        }

        $this->userRepository->save(entity: $user, flush: $flush);
    }

    public function deleteUser(User $user, bool $flush = true): void
    {
        $this->userRepository->deleteNow(entity: $user, flush: $flush);
    }

    /**
     * @throws Exception
     */
    public function reactivateUser(int $id, bool $flush = true): void
    {
        $userFound = $this->userRepository->find($id, onlyActive: false);

        if(!$userFound) {
            throw new Exception('Usuário não encontrado.');
        }

        $this->userRepository->reactivate($userFound);
    }
}