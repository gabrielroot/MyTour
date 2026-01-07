<?php

namespace MyTour\CoreBundle\EventListener;

use Doctrine\ORM\EntityManagerInterface;
use MyTour\CoreBundle\Entity\Company;
use MyTour\CoreBundle\Exception\CompanyInactiveException;
use MyTour\CoreBundle\Utils\GlobalSession;
use MyTour\UserBundle\Entity\Admin;
use MyTour\UserBundle\Entity\Organizer;
use MyTour\UserBundle\Entity\Traveler;
use MyTour\UserBundle\Entity\User;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBag;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;

class AuthenticationListener
{
    public function __construct(
        readonly private EntityManagerInterface $em,
        readonly private TokenStorageInterface $tokenStorage)
    {}

    public function onAuthenticationSuccess(InteractiveLoginEvent $event): void
    {
        $user = $event->getAuthenticationToken()->getUser();
        $this->manageSession($user);
        $user->setLastLogin(new \DateTime());
        $this->em->getRepository(User::class)->save($user);
    }

    /**
     * @throws CompanyInactiveException
     */
    private function manageSession(UserInterface $user): void
    {
        $extendedUser = $this->em->getRepository($user::class)->find($user->getId());
        /** @var Organizer|User|Traveler|Admin $currentCompany */
        $currentCompany = $this->em->getRepository(Company::class)
            ->find(id: $extendedUser->getCompany()->getId(), onlyActive: false);

        if (!$currentCompany->isActive()) {
            $this->tokenStorage->setToken(null);
            GlobalSession::getSession()->invalidate();
            throw new CompanyInactiveException();
        }

        GlobalSession::put('loggedInUser', $extendedUser);
        GlobalSession::put('currentCompany', $currentCompany);
    }
}