<?php

namespace MyTour\UserBundle\Form;

use MyTour\CoreBundle\Form\Custom\DateTimePickerType;
use MyTour\CoreBundle\Utils\Enum\RoleEnum;
use MyTour\UserBundle\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nome:',
                'attr' => [ 'placeholder' => 'Informe o nome'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Por favor, informe um valor.',
                    ]),
                ],
            ])
            ->add('username', TextType::class, [
                'label' => 'Login:',
                'attr' => [ 'placeholder' => 'Informe o nome de usuário'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Por favor, informe um valor.',
                    ]),
                    new Length([
                        'min' => 4,
                        'minMessage' => 'O login precisa ter ao menos {{ limit }} caracteres.',
                        'max' => 50,
                    ]),
                ],
            ])
            ->add('birthday', DateTimePickerType::class, [
                'label' => 'Data de nascimento:',
                'label_attr' => ['class' => 'mt-1'],
                'attr' => [
                    'class' => 'flatpickr flatpickr-input',
                    'placeholder' => 'Nasceu em...',
                    'autocomplete' => 'off'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Por favor, informe um valor.',
                    ]),
                ],
            ])
            ->add('roles', ChoiceType::class, [
                'label' => 'Nível de acesso:',
                'multiple' => true,
                'placeholder' => 'Informe o nível de acesso',
                'attr' => [
                    'class' => 'form-select select2',
                ],
                'choices' => RoleEnum::getAllValueAndName(),
                'constraints' => [
                    new NotBlank([
                        'message' => 'Por favor, informe um valor.',
                    ]),
                ],
            ])
            ->add('password', PasswordType::class, [
                'label' => 'Senha',
                'attr' => [
                    'placeholder' => 'Uma senha para o usuário',
                    'autocomplete' => 'new-password',
                ],
                'required' => false,
            ])
        ;

        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) use ($options) {
            $user = $event->getData();
            $form = $event->getForm();

            // Verifica se o usuário é novo (sem ID) ou está editando
            $isEditing = $user->getId();
            if ($isEditing) return null;

            // Se o usuário for novo ou se ele está tentando mudar a senha, tornamos o campo obrigatório
            $form->add('password', PasswordType::class, [
                'label' => 'Senha',
                'attr' => [
                    'placeholder' => 'Uma senha para o usuário',
                    'autocomplete' => 'new-password',
                ],
                'required' => false,
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
            ]);
        });
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class
        ]);
    }
}