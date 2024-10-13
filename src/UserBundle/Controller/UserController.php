<?php

declare(strict_types=1);

namespace MyTour\UserBundle\Controller;

use Exception;
use Knp\Component\Pager\PaginatorInterface;
use MyTour\CoreBundle\Controller\AbstractController;
use MyTour\UserBundle\Service\UserService;
use MyTour\UserBundle\Entity\Filter\UserFormFilter;
use MyTour\UserBundle\Entity\User;
use MyTour\UserBundle\Form\Filter\UserFilterType;
use MyTour\UserBundle\Form\UserType;
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

        $pagination = $paginator->paginate(
            $userService->findByFilter($userFilter),
            $request->query->getInt('page', 1),
            $userFilter->getPerPage()
        );

        return $this->render('@UserBundle/User/index.html.twig', [
            'entities' => $pagination,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/create', name: 'create')]
    public function create(Request $request, UserService $userService): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $userService->createUser($user);
                $this->addSuccessMessage("O usuário \"{$user->getName()}\", agora faz parte do sistema!");
                return $this->redirectToRoute('user_index');
            } catch (Exception $exception) {
                $this->addErrorMessage($exception->getMessage());
            }
        }

        return $this->render('@UserBundle/User/create.html.twig', ['form' => $form->createView()]);
    }

    #[Route('/update/{user}', name: 'update')]
    public function update(Request $request, UserService $userService, User $user): Response
    {
        $userBefore = clone $user;
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $userService->updateUser($user, $userBefore);
                $this->addSuccessMessage("O usuário \"{$user->getName()}\", foi editado com sucesso!");
                return $this->redirectToRoute('user_index');
            } catch (Exception $exception) {
                $this->addErrorMessage($exception->getMessage());
            }
        }

        return $this->render('@UserBundle/User/update.html.twig', ['form' => $form->createView()]);
    }

    #[Route('/delete/{user}', name: 'delete')]
    public function delete(UserService $userService, User $user, Request $request): Response
    {
        try {
            $userService->deleteUser($user);
            $this->addSuccessMessage("O usuário foi removido do sistema!");
        } catch (Exception $exception) {
            $this->addErrorMessage($exception->getMessage());
        }

        return $this->redirectToReferer($request, $this->generateUrl('user_index'));
    }

    #[Route('/reactivate/{user_id}', name: 'reactivate')]
    public function reactivate(UserService $userService, int $user_id, Request $request): Response
    {
        try {
            $userService->reactivateUser($user_id);
            $this->addSuccessMessage("O usuário foi reativado!");
        } catch (Exception $exception) {
            $this->addErrorMessage($exception->getMessage());
        }

        return $this->redirectToReferer($request, $this->generateUrl('user_index'));
    }

    #[Route(path: '/logout', name: 'logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}