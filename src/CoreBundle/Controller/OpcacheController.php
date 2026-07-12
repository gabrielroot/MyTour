<?php

namespace MyTour\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

/**
 * Controller to serve Opcache monitoring files with authentication protection.
 */
#[Route(path: '/monitoring', name: 'opcache_')]
#[IsGranted('IS_AUTHENTICATED_FULLY')]
class OpcacheController extends AbstractController
{
    #[Route(path: '/opcache/7.1', name: 'php71')]
    public function opcache71(): Response
    {
        $opcacheFile = $this->getParameter('kernel.project_dir') . '/src/CoreBundle/Utils/monitoring/opcache7.1.php';

        if (!file_exists($opcacheFile)) {
            throw $this->createNotFoundException('Opcache 7.1 file not found');
        }

        ob_start();
        include $opcacheFile;
        $content = ob_get_clean();

        return new Response($content, 200, [
            'Content-Type' => 'text/html; charset=UTF-8',
        ]);
    }

    #[Route(path: '/opcache/8.2', name: 'php82')]
    public function opcache82(): Response
    {
        $opcacheFile = $this->getParameter('kernel.project_dir') . '/src/CoreBundle/Utils/monitoring/opcache8.2.php';

        if (!file_exists($opcacheFile)) {
            throw $this->createNotFoundException('Opcache 8.2 file not found');
        }

        ob_start();
        include $opcacheFile;
        $content = ob_get_clean();

        return new Response($content, 200, [
            'Content-Type' => 'text/html; charset=UTF-8',
        ]);
    }

    #[Route(path: '/phpinfo', name: 'phpinfo')]
    public function phpinfo(): Response
    {
        ob_start();
        phpinfo();
        $content = ob_get_clean();

        return new Response($content, 200, [
            'Content-Type' => 'text/html; charset=UTF-8',
        ]);
    }
}