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
use MyTour\UserBundle\Repository\UserRepository;

class UserFixtures extends Fixture
{
    private UserService $userService;

    private UserRepository $userRepository;

    private array $names = ["João Pedro", "Maria Luiza", "Antonio Carlos", "Beatriz Silva", "Carlos Eduardo",
        "Felipe Alves", "Camila Rodrigues", "Matheus Ferreira", "Larissa Martins", "Vinicius Lima", "Amanda Pereira",
        "Pedro Lucas", "Juliana Araújo", "Rafael Cardoso", "Gabriela Silva", "Luiz Gustavo", "Isabela Santos",
        "Matheus Oliveira", "Camila Alves", "Vinicius Costa", "Amanda Rodrigues", "Thiago Ferreira", "Juliana Martins",
        "Anderson Lima", "Caroline Souza", "Lucas Ribeiro", "Beatriz Gonçalves", "Ricardo Dias"];

    private array $usernames = ["leao", "tigre", "urso", "macaco", "gorila", "chimpanze", "orangotango", "golfinho",
        "baleia", "tubarao", "crocodilo", "jacare", "cobra", "lagarto", "tartaruga", "coruja", "falcao", "aguia",
        "pato", "galinha", "boi", "vaca", "ovelha", "cavalo", "burro"];

    public function __construct(UserService $userService, UserRepository $userRepository)
    {
        $this->userService = $userService;
        $this->userRepository = $userRepository;
    }

    public function load(ObjectManager $manager): void
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
            $user = new User();
            $user
                ->setName($this->generateName())
                ->setUsername($this->generateUsername())
                ->setPassword('123')
                ->setRoles($this->generateRole())
                ->setBirthday(new DateTime(rand(1970, 2006) . '-' . rand(1, 12) . '-' . rand(1, 28)))
                ->setDeletedAt(
                    rand(0, 1)
                    ? new DateTime(rand(2020, 2024) . '-' . rand(1, 12) . '-' . rand(1, 28))
                    : null);

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