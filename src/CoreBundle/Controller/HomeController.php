<?php

namespace MyTour\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use MyTour\UserBundle\Service\UserStatsService;

#[Route(path: '/', name: 'home_')]
class HomeController extends AbstractController
{
    #[Route(path: '/', name: 'index')]
    public function index(UserStatsService $userStatsService): Response
    {
        $stats = $userStatsService->getUserStats();

        return $this->render('@CoreBundle/pages/dashboard/home_dashboard.html.twig', [
            'userCount' => $stats['userCount'],
            'organizerCount' => $stats['organizerCount'],
            'travelerCount' => $stats['travelerCount'],
            'adminCount' => $stats['adminCount'],
        ]);
    }
}