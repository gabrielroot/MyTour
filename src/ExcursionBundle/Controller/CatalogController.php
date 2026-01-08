<?php

declare(strict_types=1);

namespace MyTour\ExcursionBundle\Controller;

use Exception;
use Knp\Component\Pager\PaginatorInterface;
use MyTour\CoreBundle\Controller\AbstractController;
use MyTour\ExcursionBundle\Entity\Catalog;
use MyTour\ExcursionBundle\Entity\Filter\CatalogFormFilter;
use MyTour\ExcursionBundle\Form\CatalogType;
use MyTour\ExcursionBundle\Form\Filter\CatalogFilterType;
use MyTour\ExcursionBundle\Service\CatalogService;
use MyTour\UserBundle\Repository\OrganizerRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(path: 'catalog', name: 'catalog_')]
class CatalogController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(
        Request            $request,
        CatalogService     $catalogService,
        PaginatorInterface $paginator): Response
    {
        $catalogFilter = new CatalogFormFilter();
        $form = $this->createForm(CatalogFilterType::class, $catalogFilter, ['method' => 'GET']);
        $form->handleRequest($request);

        $pagination = $paginator->paginate(
            $catalogService->findByFilter($catalogFilter),
            $request->query->getInt('page', 1),
            $catalogFilter->getPerPage()
        );

        return $this->render('@ExcursionBundle/Catalog/index.html.twig', [
            'entities' => $pagination,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/create', name: 'create')]
    public function create(
        Request $request,
        CatalogService $catalogService,
        OrganizerRepository $organizerRepository): Response
    {
        $catalog = new Catalog();
        $form = $this->createForm(CatalogType::class, $catalog);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $catalogService->createCatalog($catalog);
                $this->addSuccessMessage("O catálogo \"{$catalog->getTitle()}\", agora faz parte do sistema!");
                return $this->redirectToRoute('catalog_index');
            } catch (Exception $exception) {
                $this->addErrorMessage($exception->getMessage());
            }
        }

        return $this->render('@ExcursionBundle/Catalog/create.html.twig', ['form' => $form->createView()]);
    }

    #[Route('/update/{catalog}', name: 'update')]
    public function update(Request $request, CatalogService $catalogService, Catalog $catalog): Response
    {
        $form = $this->createForm(CatalogType::class, $catalog);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $catalogService->updateCatalog($catalog);
                $this->addSuccessMessage("O catálogo \"{$catalog->getTitle()}\", foi editado com sucesso!");
                return $this->redirectToRoute('catalog_index');
            } catch (Exception $exception) {
                $this->addErrorMessage($exception->getMessage());
            }
        }

        return $this->render('@ExcursionBundle/Catalog/update.html.twig', ['form' => $form->createView()]);
    }

    #[Route('/delete/{catalog}', name: 'delete')]
    public function delete(CatalogService $catalogService, Catalog $catalog, Request $request): Response
    {
        try {
            $catalogService->deleteCatalog($catalog);
            $this->addSuccessMessage("O catálogo foi removido do sistema!");
        } catch (Exception $exception) {
            $this->addErrorMessage($exception->getMessage());
        }

        return $this->redirectToReferer($request, $this->generateUrl('catalog_index'));
    }

    #[Route('/reactivate/{catalog_id}', name: 'reactivate')]
    public function reactivate(CatalogService $catalogService, int $catalog_id, Request $request): Response
    {
        try {
            $catalogService->reactivateCatalog($catalog_id);
            $this->addSuccessMessage("O catálogo foi reativado!");
        } catch (Exception $exception) {
            $this->addErrorMessage($exception->getMessage());
        }

        return $this->redirectToReferer($request, $this->generateUrl('catalog_index'));
    }
}