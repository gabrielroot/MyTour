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
            ->add('username', TextType::class, [
                'label' => 'Nome de usuário',
                'attr' => [
                    'placeholder' => 'Informe o nome de usuário',
                    'class' => 'form-control-sm',
                ],
                'required' => false
            ])
            ->add('role', ChoiceType::class, [
                'label' => 'Nível de acesso',
                'attr' => [
                    'placeholder' => 'Informe o nível de acesso',
                    'class' => 'form-select form-control-sm',
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