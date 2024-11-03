<?php

namespace MyTour\CoreBundle\Utils;

use MyTour\CoreBundle\Entity\Company;
use MyTour\UserBundle\Entity\User;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class GlobalSession
{
    private static ?SessionInterface $session = null;

    public function __construct() {}

    public static function getSession(): SessionInterface
    {
        if (self::$session === null) {
            self::$session = new Session();
        }

        return self::$session;
    }

    public static function put(string $name, mixed $value): void
    {
        self::getSession()->set($name, $value);
    }

    public static function getLoggedInUser(): ?User
    {
        return self::getSession()->get('loggedInUser');
    }

    public static function getCurrentCompany(): ?Company
    {
        return self::getSession()->get('currentCompany');
    }
}