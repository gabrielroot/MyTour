<?php

namespace MyTour\UserBundle\Form;

use MyTour\UserBundle\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('username', TextType::class, [
                'label' => 'Nome de usuário',
                'attr' => [
                    'placeholder' => 'Seu nome de usuário',
                    'class' => 'form-control form-control-lg',
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Por favor, informe seu nome de usuário.',
                    ])
                ]
            ])
            ->add('plainPassword', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'label' => 'Senha',
                'attr' => [
                    'placeholder' => 'Sua senha',
                    'autocomplete' => 'new-password',
                    'class' => 'form-control form-control-lg'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Por favor, informe a senha.',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Sua senha precisa ter ao menos {{ limit }} caracteres.',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
