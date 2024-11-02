<?php

namespace MyTour\UserBundle\Entity;

use DateTime;
use MyTour\CoreBundle\Entity\Company;
use MyTour\CoreBundle\Interface\IAudit;
use MyTour\CoreBundle\Utils\Enum\RoleEnum;
use MyTour\CoreBundle\Utils\Trait\AuditTrait;
use MyTour\UserBundle\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: 'users')]
#[ORM\InheritanceType('JOINED')]
#[ORM\DiscriminatorColumn(name: 'type', type: 'string')]
#[ORM\DiscriminatorMap([
    'ORGANIZER' => Organizer::class,
    'TRAVELER' => Traveler::class,
    'ADMIN' => Admin::class,
    'USER' => self::class
])]
#[UniqueEntity(fields: ['username'], message: 'There is already an account with this username')]
class User implements UserInterface, PasswordAuthenticatedUserInterface, IAudit
{
    use AuditTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $name;

    #[ORM\Column(type: 'string', length: 180, unique: true)]
    private ?string $username;

    #[ORM\Column(type: 'json')]
    private array $roles = [];

    #[ORM\Column(type: 'string')]
    private ?string $password;

    #[ORM\Column(type: 'datetime', )]
    protected ?DateTime $birthday = null;

    #[ORM\Column(type: 'datetime', nullable: true)]
    protected ?DateTime $lastLogin = null;

    #[ORM\ManyToOne(targetEntity: Company::class, inversedBy: 'users')]
    private Company $company;

    public function __construct()
    {
        $this->roles = [RoleEnum::ROLE_USER->name];
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * The public representation of the user (e.g. a username, an email address, etc.)
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->username;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = RoleEnum::ROLE_USER->value;

        return array_unique($roles);
    }

    /**
     * @see UserInterface
     */
    public function getRoleName(): string
    {
        return RoleEnum::fromName($this->getRoles()[0])->value;
    }

    /**
     * @see UserInterface
     */
    public function getRoleBadge(): string
    {
        return RoleEnum::fromNameBadge($this->getRoles()[0]);
    }
    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * @return string the hashed password for this user
     */
    public function setPassword(?string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getLastLogin(): ?DateTime
    {
        return $this->lastLogin;
    }

    public function setLastLogin(?DateTime $lastLogin): self
    {
        $this->lastLogin = $lastLogin;
        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): User
    {
        $this->name = $name;
        return $this;
    }

    public function getBirthday(): ?DateTime
    {
        return $this->birthday;
    }

    public function setBirthday(DateTime $birthday): User
    {
        $this->birthday = $birthday;
        return $this;
    }


    public function getCompany(): Company
    {
        return $this->company;
    }

    public function setCompany(Company $company): User
    {
        $this->company = $company;
        return $this;
    }
}