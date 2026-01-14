<?php

declare(strict_types=1);

namespace MyTour\ExcursionBundle\Controller\Api;

use MyTour\CoreBundle\Controller\AbstractController;
use Psr\Log\LoggerInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use MyTour\Integrations\OpenStreetMapIntegration;

#[Route(path: 'map', name: 'map_')]
class OpenStreetMapController extends AbstractController
{
    #[Route('/search-address/', name: 'search_address', methods: ['GET'])]
    public function searchAddress(Request $request, OpenStreetMapIntegration $openStreetMapIntegration, LoggerInterface $logger): JsonResponse
    {
        $query = trim((string) $request->query->get('q', ''));

        if ($query === '') {
            return new JsonResponse(['error' => 'O local não foi informado'], JsonResponse::HTTP_BAD_REQUEST);
        }

        // If the session is started, save it to release the lock before performing external I/O
        if ($request->hasSession()) {
            $session = $request->getSession();
            if ($session->isStarted()) {
                $session->save();
            }
        }

        try {
            $results = $openStreetMapIntegration->searchAddress($query);
            return new JsonResponse($results, JsonResponse::HTTP_OK);
        } catch (\Throwable $e) {
            // Log the exception and return a 502 (bad gateway) as the integration failed
            $logger->error('OpenStreetMap search error: ' . $e->getMessage(), ['exception' => $e]);

            return new JsonResponse(['error' => 'external_service_error'], JsonResponse::HTTP_BAD_GATEWAY);
        }
    }
}