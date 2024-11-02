<?php

declare(strict_types=1);

namespace MyTour\CoreBundle\Controller;

use Exception;
use Knp\Component\Pager\PaginatorInterface;
use MyTour\CoreBundle\Entity\Company;
use MyTour\CoreBundle\Entity\Filter\CompanyFormFilter;
use MyTour\CoreBundle\Form\CompanyType;
use MyTour\CoreBundle\Form\Filter\CompanyFilterType;
use MyTour\CoreBundle\Service\CompanyService;
use MyTour\UserBundle\Entity\Admin;
use MyTour\UserBundle\Entity\Organizer;
use MyTour\UserBundle\Repository\OrganizerRepository;
use MyTour\UserBundle\Repository\UserRepository;
use MyTour\UserBundle\Service\UserService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route(path: 'company', name: 'company_')]
class CompanyController extends AbstractController
{
    #[Route('/', name: 'index')]
    #[IsGranted(attribute: 'ROLE_ADMIN')]
    public function index(
        Request            $request,
        CompanyService     $companyService,
        PaginatorInterface $paginator): Response
    {
        $companyFilter = new CompanyFormFilter();
        $form = $this->createForm(CompanyFilterType::class, $companyFilter, ['method' => 'GET']);
        $form->handleRequest($request);

        $pagination = $paginator->paginate(
            $companyService->findByFilter($companyFilter),
            $request->query->getInt('page', 1),
            $companyFilter->getPerPage()
        );

        return $this->render('@CoreBundle/pages/company/index.html.twig', [
            'entities' => $pagination,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/create', name: 'create')]
    #[IsGranted(attribute: 'ROLE_ADMIN')]
    public function create(
        Request $request,
        CompanyService $companyService,
        OrganizerRepository $organizerRepository): Response
    {
        $company = new Company();
        $form = $this->createForm(CompanyType::class, $company);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $companyService->createCompany($company);
                $this->addSuccessMessage("A empresa \"{$company->getFantasyName()}\", agora faz parte do sistema!");
                return $this->redirectToRoute('company_index');
            } catch (Exception $exception) {
                $this->addErrorMessage($exception->getMessage());
            }
        }

        return $this->render('@CoreBundle/pages/company/create.html.twig', ['form' => $form->createView()]);
    }

    #[Route('/update/{company}', name: 'update')]
    #[IsGranted(attribute: 'ROLE_ORGANIZER')]
    public function update(
        Request $request,
        CompanyService $companyService,
        Company $company,
        UserRepository $userRepository): Response
    {
        $form = $this->createForm(CompanyType::class, $company);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $companyService->updateCompany($company);
                $this->addSuccessMessage("A empresa \"{$company->getFantasyName()}\", foi editado com sucesso!");
            } catch (Exception $exception) {
                $this->addErrorMessage($exception->getMessage());
            }
        }

        return $this->render('@CoreBundle/pages/company/update.html.twig', ['form' => $form->createView()]);
    }

    #[Route('/delete/{company}', name: 'delete')]
    #[IsGranted(attribute: 'ROLE_ADMIN')]
    public function delete(CompanyService $companyService, Company $company, Request $request): Response
    {
        try {
            $companyService->deleteCompany($company);
            $this->addSuccessMessage("A empresa foi removida do sistema!");
        } catch (Exception $exception) {
            $this->addErrorMessage($exception->getMessage());
        }

        return $this->redirectToReferer($request, $this->generateUrl('company_index'));
    }

    #[Route('/reactivate/{company_id}', name: 'reactivate')]
    #[IsGranted(attribute: 'ROLE_ADMIN')]
    public function reactivate(CompanyService $companyService, int $company_id, Request $request): Response
    {
        try {
            $companyService->reactivateCompany($company_id);
            $this->addSuccessMessage("A empresa foi reativada!");
        } catch (Exception $exception) {
            $this->addErrorMessage($exception->getMessage());
        }

        return $this->redirectToReferer($request, $this->generateUrl('company_index'));
    }
}