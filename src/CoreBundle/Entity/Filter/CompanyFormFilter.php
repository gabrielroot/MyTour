<?php

namespace MyTour\CoreBundle\Entity\Filter;

use MyTour\CoreBundle\Entity\Filter\AbstractFormFilter;
use MyTour\UserBundle\Entity\Organizer;

class CompanyFormFilter extends AbstractFormFilter
{
    private ?string $name = null;

    private ?string $fantasyName = null;

    private ?string $cnpj = null;

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): CompanyFormFilter
    {
        $this->name = $name;
        return $this;
    }

    public function getFantasyName(): ?string
    {
        return $this->fantasyName;
    }

    public function setFantasyName(?string $fantasyName): CompanyFormFilter
    {
        $this->fantasyName = $fantasyName;
        return $this;
    }

    public function getCnpj(): ?string
    {
        return $this->cnpj;
    }

    public function setCnpj(?string $cnpj): CompanyFormFilter
    {
        $this->cnpj = $cnpj;
        return $this;
    }

}