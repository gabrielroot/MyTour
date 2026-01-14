<?php

declare(strict_types=1);

namespace MyTour\ExcursionBundle\Controller;

use Exception;
use Knp\Component\Pager\PaginatorInterface;
use MyTour\CoreBundle\Controller\AbstractController;
use MyTour\ExcursionBundle\Entity\Trip;
use MyTour\ExcursionBundle\Entity\Filter\TripFormFilter;
use MyTour\ExcursionBundle\Form\TripType;
use MyTour\ExcursionBundle\Form\Filter\TripFilterType;
use MyTour\ExcursionBundle\Service\TripService;
use MyTour\UserBundle\Repository\OrganizerRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(path: 'trip', name: 'trip_')]
class TripController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(
        Request            $request,
        TripService     $tripService,
        PaginatorInterface $paginator): Response
    {
        $tripFilter = new TripFormFilter();
        $form = $this->createForm(TripFilterType::class, $tripFilter, ['method' => 'GET']);
        $form->handleRequest($request);

        $pagination = $paginator->paginate(
            $tripService->findByFilter($tripFilter),
            $request->query->getInt('page', 1),
            $tripFilter->getPerPage()
        );

        return $this->render('@ExcursionBundle/Trip/index.html.twig', [
            'entities' => $pagination,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/create', name: 'create')]
    public function create(
        Request $request,
        TripService $tripService,
        OrganizerRepository $organizerRepository): Response
    {
        $trip = new Trip();
        $form = $this->createForm(TripType::class, $trip);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $tripService->createTrip($trip);
                $this->addSuccessMessage("A viagem \"{$trip->getTitle()}\", agora faz parte do sistema!");
                return $this->redirectToRoute('trip_index');
            } catch (Exception $exception) {
                $this->addErrorMessage($exception->getMessage());
            }
        }

        return $this->render('@ExcursionBundle/Trip/create.html.twig', ['form' => $form->createView()]);
    }

    #[Route('/update/{trip}', name: 'update')]
    public function update(Request $request, TripService $tripService, Trip $trip): Response
    {
        $form = $this->createForm(TripType::class, $trip);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $tripService->updateTrip($trip);
                $this->addSuccessMessage("A viagem \"{$trip->getTitle()}\", foi editada com sucesso!");
                return $this->redirectToRoute('trip_index');
            } catch (Exception $exception) {
                $this->addErrorMessage($exception->getMessage());
            }
        }

        return $this->render('@ExcursionBundle/Trip/update.html.twig', ['form' => $form->createView()]);
    }

    #[Route('/delete/{trip}', name: 'delete')]
    public function delete(TripService $tripService, Trip $trip, Request $request): Response
    {
        try {
            $tripService->deleteTrip($trip);
            $this->addSuccessMessage("A viagem foi removida do sistema!");
        } catch (Exception $exception) {
            $this->addErrorMessage($exception->getMessage());
        }

        return $this->redirectToReferer($request, $this->generateUrl('trip_index'));
    }

    #[Route('/reactivate/{trip_id}', name: 'reactivate')]
    public function reactivate(TripService $tripService, int $trip_id, Request $request): Response
    {
        try {
            $tripService->reactivateTrip($trip_id);
            $this->addSuccessMessage("A viagem foi reativada!");
        } catch (Exception $exception) {
            $this->addErrorMessage($exception->getMessage());
        }

        return $this->redirectToReferer($request, $this->generateUrl('trip_index'));
    }
}