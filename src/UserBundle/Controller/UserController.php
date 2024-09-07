<?php

declare(strict_types=1);

namespace MyTour\UserBundle\Controller;

use Knp\Component\Pager\PaginatorInterface;
use MyTour\CoreBundle\Controller\AbstractController;
use MyTour\CoreBundle\Services\UserService;
use MyTour\UserBundle\Entity\Filter\UserFormFilter;
use MyTour\UserBundle\Form\Filter\UserFilterType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(path: 'user', name: 'user_')]
class UserController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(
        Request $request,
        UserService $userService,
        PaginatorInterface $paginator): Response
    {
        $userFilter = new UserFormFilter();
        $form = $this->createForm(UserFilterType::class, $userFilter, ['method' => 'GET']);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
//            $this->addSuccessMessage('Testando as FLASHES!!');
        }

        $pagination = $paginator->paginate(
            $userService->findByFilter($userFilter),
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('@UserBundle/User/index.html.twig', [
            'entities' => $pagination,
            'form' => $form->createView(),
        ]);
    }

    #[Route(path: '/logout', name: 'logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}