<?php

namespace MyTour\CoreBundle\DataFixtures\CoreBundle;

use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use MyTour\CoreBundle\DataFixtures\BaseFixtures;
use MyTour\CoreBundle\DataFixtures\UserBundle\UserFixtures;
use MyTour\CoreBundle\Entity\Company;
use MyTour\CoreBundle\Service\CompanyService;

class CompanyFixtures extends BaseFixtures
{
    private CompanyService $companyService;

    public function __construct(CompanyService $companyService)
    {
        parent::__construct();
        $this->companyService = $companyService;
    }

    public function load(ObjectManager $manager): void
    {
        $this->createCompanies();

        $manager->flush();
    }

    private function createCompanies(): void
    {
        for($i = 0; $i < 20; $i++) {
            $company = new Company();
            $company
                ->setName($this->companyName[rand(0, count($this->places) - 1)])
                ->setFantasyName("Lorem Ipsum is simply")
                ->setCnpj(
                    str_pad(rand(0, 50), 2, '0')
                    . str_pad(rand(0, 999), 3, '0')
                    . str_pad(rand(0, 999), 3, '0')
                    . '0001'
                    . str_pad(rand(0, 99), 2, '0'));

            $this->setRandomDelete($company);

            $this->companyService->createCompany(company: $company, flush: false);
        }
    }
}