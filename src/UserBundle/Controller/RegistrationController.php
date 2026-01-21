<?php

namespace MyTour\UserBundle\Controller;

use Doctrine\ORM\EntityManagerInterface;
use MyTour\CoreBundle\Repository\CompanyRepository;
use MyTour\UserBundle\Entity\Traveler;
use MyTour\UserBundle\Entity\User;
use MyTour\UserBundle\Form\RegistrationFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

#[Route('registration', name: 'registration_')]
class RegistrationController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function register(
        Request $request,
        UserPasswordHasherInterface $userPasswordHasher,
        Security $security,
        CompanyRepository $companyRepository,
        EntityManagerInterface $entityManager): Response
    {
        $traveler = new Traveler();
        $form = $this->createForm(RegistrationFormType::class, $traveler);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var string $plainPassword */
            $plainPassword = $form->get('plainPassword')->getData();

            // encode the plain password
            $traveler
                ->setCompany($companyRepository->findOneBy([]))
                ->setPassword($userPasswordHasher->hashPassword($traveler, $plainPassword));

            $entityManager->persist($traveler);
            $entityManager->flush();

            return $security->login($traveler, 'form_login', 'main');
        }

        return $this->render('@UserBundle/User/registration/register.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
