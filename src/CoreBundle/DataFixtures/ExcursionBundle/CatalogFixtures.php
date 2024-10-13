<?php

namespace MyTour\CoreBundle\DataFixtures\ExcursionBundle;

use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use MyTour\CoreBundle\DataFixtures\BaseFixtures;
use MyTour\CoreBundle\DataFixtures\UserBundle\UserFixtures;
use MyTour\ExcursionBundle\Entity\Catalog;
use MyTour\ExcursionBundle\Service\CatalogService;
use MyTour\UserBundle\Repository\OrganizerRepository;

class CatalogFixtures extends BaseFixtures implements DependentFixtureInterface
{
    private CatalogService $catalogService;

    private OrganizerRepository $organizerRepository;

    public function __construct(
        CatalogService $catalogService,
        OrganizerRepository $organizerRepository)
    {
        parent::__construct();
        $this->catalogService = $catalogService;
        $this->organizerRepository = $organizerRepository;
    }

    public function load(ObjectManager $manager): void
    {
        $this->createCatalogs();

        $manager->flush();
    }

    private function createCatalogs(): void
    {
        for($i = 0; $i < 20; $i++) {
            $catalog = new Catalog();
            $catalog
                ->setTitle($this->places[rand(0, count($this->places) - 1)])
                ->setDescription("Lorem Ipsum is simply dummy text of the printing and typesetting industry. 
                    Lorem Ipsum has been the industry's standard dummy text ever since the 1500s.")
                ->setPrice(rand(500, 3000))
                ->setOrganizer($this->organizerRepository->getOneRandom())
                ->setAvailable(rand(0, 1));

            $this->setRandomDelete($catalog);

            $this->catalogService->createCatalog(catalog: $catalog, flush: false);
        }
    }

    public function getDependencies()
    {
        return [
            UserFixtures::class,
        ];
    }
}