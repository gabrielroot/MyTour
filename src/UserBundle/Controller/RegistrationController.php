<?php

namespace MyTour\UserBundle\Controller;

use Doctrine\ORM\EntityManagerInterface;
use MyTour\CoreBundle\Repository\CompanyRepository;
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
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var string $plainPassword */
            $plainPassword = $form->get('plainPassword')->getData();

            // encode the plain password
            $user
                ->setCompany($companyRepository->findOneBy([]))
                ->setPassword($userPasswordHasher->hashPassword($user, $plainPassword));

            $entityManager->persist($user);
            $entityManager->flush();

            return $security->login($user, 'form_login', 'main');
        }

        return $this->render('@UserBundle/User/registration/register.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
