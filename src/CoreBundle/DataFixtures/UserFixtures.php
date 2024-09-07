<?php

namespace MyTour\CoreBundle\DataFixtures;

//use Doctrine\Bundle\FixturesBundle\Fixture;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\ORM\EntityManager;
use Doctrine\Persistence\ObjectManager;
use MyTour\CoreBundle\Services\UserService;
use MyTour\CoreBundle\Utils\Enum\RoleEnum;
use MyTour\UserBundle\Entity\User;

class UserFixtures extends Fixture
{
    private UserService $userService;

    private array $names = ["João Pedro", "Maria Luiza", "Antonio Carlos", "Beatriz Silva", "Carlos Eduardo",
        "Felipe Alves", "Camila Rodrigues", "Matheus Ferreira", "Larissa Martins", "Vinicius Lima", "Amanda Pereira",
        "Pedro Lucas", "Juliana Araújo", "Rafael Cardoso", "Gabriela Silva", "Luiz Gustavo", "Isabela Santos",
        "Matheus Oliveira", "Camila Alves", "Vinicius Costa", "Amanda Rodrigues", "Thiago Ferreira", "Juliana Martins",
        "Anderson Lima", "Caroline Souza", "Lucas Ribeiro", "Beatriz Gonçalves", "Ricardo Dias"];

    private array $usernames = ["leao", "tigre", "urso", "macaco", "gorila", "chimpanze", "orangotango", "golfinho",
        "baleia", "tubarao", "crocodilo", "jacare", "cobra", "lagarto", "tartaruga", "coruja", "falcao", "aguia",
        "pato", "galinha", "boi", "vaca", "ovelha", "cavalo", "burro"];

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function load(ObjectManager $manager): void
    {
        $userRoot = new User();
        $userRoot
            ->setUsername('root')
            ->setPassword('123')
            ->setRoles([RoleEnum::ROLE_ORGANIZER->name]);

        $this->userService->createUser(user: $userRoot, flush: false);

        for($i = 0; $i < 100; $i++) {
            $user = new User();
            $user
                ->setUsername($this->generateUsername())
                ->setPassword('123')
                ->setRoles($this->generateRole())
                ->setDeletedAt(rand(0, 1) ? new DateTime() : null);

            $this->userService->createUser(user: $user, flush: false);
        }

        $manager->flush();
    }


    private function generateName(): string
    {
        return $this->names[array_rand($this->names)] . rand(1, 1000);
    }

    private function generateUsername(): string
    {
        return $this->usernames[array_rand($this->usernames)] . rand(1, 1000000);
    }

    private function generateRole(): array
    {
        return [RoleEnum::getAllValueAndName()[array_rand(RoleEnum::getAllValueAndName())]];
    }
}