<?php

namespace MyTour\CoreBundle\EventListener;

use Doctrine\ORM\EntityManagerInterface;
use MyTour\UserBundle\Entity\User;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;

class AuthenticationListener
{
    public function __construct(readonly private EntityManagerInterface $em){}

    public function onAuthenticationSuccess(InteractiveLoginEvent $event): void
    {
        $user = $event->getAuthenticationToken()->getUser();
        $user->setLastLogin(new \DateTime());
        $this->em->getRepository(User::class)->save($user);
    }
}