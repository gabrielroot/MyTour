<?php

declare(strict_types=1);

namespace MyTour\ExcursionBundle\Controller;

use Exception;
use Knp\Component\Pager\PaginatorInterface;
use MyTour\CoreBundle\Controller\AbstractController;
use MyTour\ExcursionBundle\Entity\Checkpoint;
use MyTour\ExcursionBundle\Entity\Filter\CheckpointFormFilter;
use MyTour\ExcursionBundle\Entity\Filter\TripFormFilter;
use MyTour\ExcursionBundle\Entity\Trip;
use MyTour\ExcursionBundle\Form\CheckpointType;
use MyTour\ExcursionBundle\Form\Filter\CheckpointFilterType;
use MyTour\ExcursionBundle\Form\Filter\TripFilterType;
use MyTour\ExcursionBundle\Service\CheckpointService;
use MyTour\ExcursionBundle\Service\TripService;
use MyTour\UserBundle\Repository\OrganizerRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

#[Route(path: 'checkpoint', name: 'checkpoint_')]
class CheckpointController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(
        Request            $request,
        CheckpointService     $checkpointService,
        PaginatorInterface $paginator): Response
    {
        $checkpointFilter = new CheckpointFormFilter();
        $form = $this->createForm(CheckpointFilterType::class, $checkpointFilter, ['method' => 'GET']);
        $form->handleRequest($request);

        $pagination = $paginator->paginate(
            $checkpointService->findByFilter($checkpointFilter),
            $request->query->getInt('page', 1),
            $checkpointFilter->getPerPage()
        );

        return $this->render('@ExcursionBundle/Checkpoint/index.html.twig', [
            'entities' => $pagination,
            'form' => $form->createView(),
        ]);
    }


    #[Route('/trip/{trip}/list', name: 'from_trip')]
    public function checkpoints(
        Request $request,
        Trip $trip,
        CheckpointService $checkpointService,
        PaginatorInterface $paginator): Response
    {
        $checkpointFilter = new CheckpointFormFilter();
        $checkpointFilter->setTrip($trip);

        $form = $this->createForm(CheckpointFilterType::class, $checkpointFilter, ['method' => 'GET']);

        $request->attributes->add(['_route' => 'checkpoint_index']);

        $form->handleRequest($request);

        $pagination = $paginator->paginate(
            $checkpointService->findByFilter($checkpointFilter),
            $request->query->getInt('page', 1),
            $checkpointFilter->getPerPage()
        );

        return $this->render('@ExcursionBundle/Checkpoint/index.html.twig', [
            'entities' => $pagination,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/create', name: 'create')]
    public function create(
        Request $request,
        CheckpointService $checkpointService,
        OrganizerRepository $organizerRepository): Response
    {
        $checkpoint = new Checkpoint();
        $form = $this->createForm(CheckpointType::class, $checkpoint);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $checkpointService->createCheckpoint($checkpoint);
                $this->addSuccessMessage("A viagem \"{$checkpoint->getTitle()}\", agora faz parte do sistema!");
                return $this->redirectToRoute('checkpoint_index');
            } catch (Exception $exception) {
                $this->addErrorMessage($exception->getMessage());
            }
        }

        return $this->render('@ExcursionBundle/Checkpoint/create.html.twig', ['form' => $form->createView()]);
    }

    #[Route('/update/{checkpoint}', name: 'update')]
    public function update(Request $request, CheckpointService $checkpointService, Checkpoint $checkpoint): Response
    {
        $form = $this->createForm(CheckpointType::class, $checkpoint);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $checkpointService->updateCheckpoint($checkpoint);
                $this->addSuccessMessage("A viagem \"{$checkpoint->getTitle()}\", foi editada com sucesso!");
                return $this->redirectToRoute('checkpoint_index');
            } catch (Exception $exception) {
                $this->addErrorMessage($exception->getMessage());
            }
        }

        return $this->render('@ExcursionBundle/Checkpoint/update.html.twig', ['form' => $form->createView()]);
    }

    #[Route('/delete/{checkpoint}', name: 'delete')]
    public function delete(CheckpointService $checkpointService, Checkpoint $checkpoint, Request $request): Response
    {
        try {
            $checkpointService->deleteCheckpoint($checkpoint);
            $this->addSuccessMessage("A viagem foi removida do sistema!");
        } catch (Exception $exception) {
            $this->addErrorMessage($exception->getMessage());
        }

        return $this->redirectToReferer($request, $this->generateUrl('checkpoint_index'));
    }

    #[Route('/reactivate/{checkpoint_id}', name: 'reactivate')]
    public function reactivate(CheckpointService $checkpointService, int $checkpoint_id, Request $request): Response
    {
        try {
            $checkpointService->reactivateCheckpoint($checkpoint_id);
            $this->addSuccessMessage("A viagem foi reativada!");
        } catch (Exception $exception) {
            $this->addErrorMessage($exception->getMessage());
        }

        return $this->redirectToReferer($request, $this->generateUrl('checkpoint_index'));
    }
}