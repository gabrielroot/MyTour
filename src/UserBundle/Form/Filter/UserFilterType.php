<?php

namespace MyTour\UserBundle\Form\Filter;

use MyTour\CoreBundle\Form\Filter\AbstractFormType;
use MyTour\CoreBundle\Utils\Enum\RoleEnum;
use MyTour\UserBundle\Entity\Filter\UserFormFilter;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserFilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nome:',
                'attr' => [ 'placeholder' => 'Informe o nome'],
                'required' => false
            ])
            ->add('username', TextType::class, [
                'label' => 'Login:',
                'attr' => [ 'placeholder' => 'Informe o nome de usuário'],
                'required' => false
            ])
            ->add('birthday', TextType::class, [
                'label' => 'Data de nascimento:',
                'label_attr' => ['class' => 'mt-1'],
                'attr' => [
                    'class' => 'flatpickr_no_time flatpickr-input',
                    'placeholder' => 'Nasceu em...',
                    'autocomplete' => 'off'],
                'required' => false
            ])
            ->add('role', ChoiceType::class, [
                'label' => 'Nível de acesso:',
                'placeholder' => 'Informe o nível de acesso',
                'attr' => [
                    'class' => 'form-select',
                ],
                'choices' => RoleEnum::getAllValueAndName(),
                'required' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => UserFormFilter::class
        ]);
    }

    public function getParent(): string
    {
        return AbstractFormType::class;
    }
}