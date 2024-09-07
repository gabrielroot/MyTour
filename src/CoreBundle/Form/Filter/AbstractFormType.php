<?php

namespace MyTour\CoreBundle\Form\Filter;

use MyTour\CoreBundle\Entity\Filter\AbstractFormFilter;
use MyTour\UserBundle\Entity\User;
use MyTour\UserBundle\Repository\UserRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AbstractFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            //START_STATUS
            ->add('active', ChoiceType::class, [
                'choices' => ['Deletado' => 0, 'Ativo' => 1],
                'placeholder' => 'Todos',
                'label' => false,
                'attr' => ['class' => 'form-select form-control-xs'],
                'required' => false
            ])
            //END_STATUS
            //START_users
            ->add('createdBy', EntityType::class, [
                'class' => User::class,
                'choice_value' => 'id',
                'choice_label' => 'username',
                'query_builder' => function (UserRepository $repository) {
                    return $repository->newCriteriaActiveQb();
                },
                'label' => 'Criado por',
                'attr' => ['class' => 'form-select form-control-sm'],
                'placeholder' => 'Escolha um usuário',
                'required' => false
            ])
            ->add('updatedBy', EntityType::class, [
                'class' => User::class,
                'choice_value' => 'id',
                'choice_label' => 'username',
                'query_builder' => function (UserRepository $repository) {
                    return $repository->newCriteriaActiveQb();
                },
                'label' => 'Atualizado por',
                'attr' => ['class' => 'form-select form-control-sm'],
                'placeholder' => 'Escolha um usuário',
                'required' => false
            ])
            ->add('deletedBy', EntityType::class, [
                'class' => User::class,
                'choice_value' => 'id',
                'choice_label' => 'username',
                'query_builder' => function (UserRepository $repository) {
                    return $repository->newCriteriaActiveQb();
                },
                'label' => 'Deletado por',
                'attr' => ['class' => 'form-select form-control-sm'],
                'placeholder' => 'Escolha um usuário',
                'required' => false
            ])
            //END_users
            //START_TIMESTAMPS
            ->add('createdAtStart', TextType::class, [
                'label' => 'Criado de',
                'attr' => [
                    'class' => 'flatpickr flatpickr-input form-control-sm',
                    'placeholder' => 'Criado a partir de...',
                    'autocomplete' => 'off'],
                'required' => false
            ])
            ->add('createdAtEnd', TextType::class, [
                'label' => 'Criado até',
                'attr' => [
                    'class' => 'flatpickr flatpickr-input form-control-sm',
                    'placeholder' => 'Criado até...',
                    'autocomplete' => 'off'],
                'required' => false
            ])
            ->add('updatedAtStart', TextType::class, [
                'label' => 'Atualizado de',
                'attr' => [
                    'class' => 'flatpickr flatpickr-input form-control-sm',
                    'placeholder' => 'Atualizado a partir de...',
                    'autocomplete' => 'off'],
                'required' => false
            ])
            ->add('updatedAtEnd', TextType::class, [
                'label' => 'Atualizado até',
                'attr' => [
                    'class' => 'flatpickr flatpickr-input form-control-sm',
                    'placeholder' => 'Atualizado até...',
                    'autocomplete' => 'off'],
                'required' => false
            ])
            ->add('deletedAtStart', TextType::class, [
                'label' => 'Deletado de',
                'attr' => [
                    'class' => 'flatpickr flatpickr-input form-control-sm',
                    'placeholder' => 'Atualizado a partir de...',
                    'autocomplete' => 'off'],
                'required' => false
            ])
            ->add('deletedAtEnd', TextType::class, [
                'label' => 'Deletado até',
                'attr' => [
                    'class' => 'flatpickr flatpickr-input form-control-sm',
                    'placeholder' => 'Atualizado até...',
                    'autocomplete' => 'off'],
                'required' => false
            ])
            //END_TIMESTAMPS
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => AbstractFormFilter::class
        ]);
    }
}