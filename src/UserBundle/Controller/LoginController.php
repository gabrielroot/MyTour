<?php

namespace MyTour\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class LoginController extends AbstractController
{
    #[Route('/login', name: 'login')]
    public function login(): Response
    {
        $number = random_int(0, 100);

        return new Response(
            '<html lang="en"><body>Lucky number: '.$number.'</body></html>'
        );
    }
}