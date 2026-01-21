<?php

namespace MyTour\CoreBundle\DataFixtures\UserBundle;

use DateTime;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use MyTour\CoreBundle\DataFixtures\BaseFixtures;
use MyTour\CoreBundle\DataFixtures\CoreBundle\CompanyFixtures;
use MyTour\CoreBundle\Repository\CompanyRepository;
use MyTour\CoreBundle\Utils\Enum\RoleEnum;
use MyTour\UserBundle\Entity\Admin;
use MyTour\UserBundle\Entity\Organizer;
use MyTour\UserBundle\Entity\Traveler;
use MyTour\UserBundle\Entity\User;
use MyTour\UserBundle\Repository\UserRepository;
use MyTour\UserBundle\Service\UserService;

class UserFixtures extends BaseFixtures implements DependentFixtureInterface
{
    private UserService $userService;

    private UserRepository $userRepository;

    private CompanyRepository $companyRepository;

    public function __construct(
        UserService $userService,
        UserRepository $userRepository,
        CompanyRepository $companyRepository)
    {
        parent::__construct();
        $this->userService = $userService;
        $this->userRepository = $userRepository;
        $this->companyRepository = $companyRepository;
    }

    public function load(ObjectManager $manager): void
    {
        $this->createUsers();

        $manager->flush();
    }

    private function createUsers(): void
    {
        if (!$this->userRepository->findOneBy(['username' => 'root'])) {
            $userRoot = new User();
            $userRoot
                ->setName('Gabriel')
                ->setUsername('root')
                ->setPassword('123')
                ->setRoles([RoleEnum::ROLE_ORGANIZER->name])
                ->setBirthday(new DateTime('1970-05-26'))
                ->setCompany($this->companyRepository->getOneRandom());

            $this->userService->createUser(user: $userRoot, flush: false);
        }

        for($i = 0; $i < 100; $i++) {
            $userTypes = [new User(), new Traveler(), new Organizer(), new Admin()];
            /** @var User|Traveler|Organizer|Admin $user */
            $user = $userTypes[rand(0, count($userTypes) - 1)];

            $user
                ->setName($this->generateName())
                ->setUsername($this->generateUsername())
                ->setPassword('123')
                ->setRoles($this->generateRole())
                ->setBirthday(new DateTime(rand(1970, 2006) . '-' . rand(1, 12) . '-' . rand(1, 28)))
                ->setCompany($this->companyRepository->getOneRandom());

            $this->setRandomDelete($user);

            $this->userService->createUser(user: $user, flush: false);
        }
    }

    public function getDependencies(): array
    {
        return [
            CompanyFixtures::class,
        ];
    }
}