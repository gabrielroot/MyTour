<?php

namespace MyTour\CoreBundle\EventListener;

use DateTime;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use MyTour\CoreBundle\Interface\IAudit;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class AuditListener
{

    public function __construct(readonly private TokenStorageInterface $tokenStorage)
    {
    }

    public function prePersist(LifecycleEventArgs $args): void
    {
        $this->setAuditTrait($args);
    }

    public function preUpdate(LifecycleEventArgs $args): void
    {
        $this->setAuditTrait($args);
    }
    private function setAuditTrait(LifecycleEventArgs $args): void
    {
        $entity = $args->getObject();
        if (is_subclass_of($entity, IAudit::class)) {
            $this->setDateTime($entity);
            $this->setUser($entity);
        }
    }

    private function setDateTime(IAudit $entity): void
    {
        $entity->setUpdatedAt(new DateTime('now'));

        if (!$entity->getId())
            $entity->setCreatedAt(new DateTime('now'));
    }

    private function setUser(IAudit $entity): void
    {
        if ($currentUser = $this->getUser()) {
            $entity->setUpdatedBy($currentUser);

            if (!$entity->getId())
                $entity->setCreatedBy($currentUser);
        }
    }

    /**
     * @return UserInterface|null
     */
    public function getUser(): ?UserInterface
    {
        if (!$this->tokenStorage) {
            throw new \LogicException('The SecurityBundle is not registered in your application.');
        }

        if (null === $token = $this->tokenStorage->getToken()) {
            return null;
        }

        if (!is_object($user = $token->getUser())) {
            // e.g. anonymous authentication
            return null;
        }

        return $user;
    }
}
