<?php

namespace MyTour\CoreBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use MyTour\CoreBundle\Interface\IAudit;
use MyTour\CoreBundle\Repository\CompanyRepository;
use MyTour\CoreBundle\Utils\Trait\AuditTrait;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use MyTour\UserBundle\Entity\User;

#[ORM\Entity(repositoryClass: CompanyRepository::class)]
#[ORM\Table(name: 'companies')]
class Company implements IAudit
{
    use AuditTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 255)]
    private string $name;

    #[ORM\Column(type: 'string', length: 255)]
    private string $fantasyName;

    #[Assert\Length(max: 14, maxMessage: 'O CNPJ deve conter no máximo 14 caracteres.')]
    #[ORM\Column(type: 'string', length: 14, nullable: true)]
    private ?string $cnpj;

    #[ORM\OneToMany(targetEntity: User::class, mappedBy: 'company')]
    private Collection $users;

    public function __construct() {
        $this->users = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): Company
    {
        $this->id = $id;
        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): Company
    {
        $this->name = $name;
        return $this;
    }

    public function getFantasyName(): string
    {
        return $this->fantasyName;
    }

    public function setFantasyName(string $fantasyName): Company
    {
        $this->fantasyName = $fantasyName;
        return $this;
    }

    public function getCnpj(): ?string
    {
        return $this->cnpj;
    }

    public function setCnpj(?string $cnpj): Company
    {
        $this->cnpj = $cnpj;
        return $this;
    }

    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function setUsers(Collection $users): Company
    {
        $this->users = $users;
        return $this;
    }

}