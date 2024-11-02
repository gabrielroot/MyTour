<?php

namespace MyTour\CoreBundle\Utils\TwigVars;

use Symfony\Bridge\Twig\AppVariable;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\User\UserInterface;

class GlobalVariableTwig extends AppVariable
{
    public function __construct()
    {
    }
}