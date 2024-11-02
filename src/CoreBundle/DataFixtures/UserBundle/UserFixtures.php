<?php

namespace MyTour\CoreBundle\DataFixtures\UserBundle;

use DateTime;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use MyTour\CoreBundle\DataFixtures\BaseFixtures;
use MyTour\CoreBundle\DataFixtures\CoreBundle\CompanyFixtures;
use MyTour\CoreBundle\Utils\Enum\RoleEnum;
use MyTour\UserBundle\Entity\Organizer;
use MyTour\UserBundle\Entity\Traveler;
use MyTour\UserBundle\Entity\User;
use MyTour\UserBundle\Repository\UserRepository;
use MyTour\UserBundle\Service\UserService;

class UserFixtures extends BaseFixtures implements DependentFixtureInterface
{
    private UserService $userService;

    private UserRepository $userRepository;

    public function __construct(
        UserService $userService,
        UserRepository $userRepository)
    {
        parent::__construct();
        $this->userService = $userService;
        $this->userRepository = $userRepository;
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
                ->setBirthday(new DateTime('1970-05-26'));

            $this->userService->createUser(user: $userRoot, flush: false);
        }

        for($i = 0; $i < 100; $i++) {
            $userTypes = [new User(), new Traveler(), new Organizer()];
            $user = $userTypes[rand(0, count($userTypes) - 1)];
            $user
                ->setName($this->generateName())
                ->setUsername($this->generateUsername())
                ->setPassword('123')
                ->setRoles($this->generateRole())
                ->setBirthday(new DateTime(rand(1970, 2006) . '-' . rand(1, 12) . '-' . rand(1, 28)));

            $this->setRandomDelete($user);

            $this->userService->createUser(user: $user, flush: false);
        }
    }

    public function getDependencies()
    {
        return [
            CompanyFixtures::class,
        ];
    }
}