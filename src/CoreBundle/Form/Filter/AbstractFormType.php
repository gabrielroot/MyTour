<?php

namespace MyTour\CoreBundle\Form\Filter;

use MyTour\CoreBundle\Entity\Filter\AbstractFormFilter;
use MyTour\CoreBundle\Form\Custom\DateTimePickerType;
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
                'attr' => ['onChange' => 'this.form.submit()'],
                'required' => false
            ])
            //END_STATUS
            //START_PER_PAGE
            ->add('perPage', ChoiceType::class, [
                'label' => false,
                'attr' => ['onChange' => 'this.form.submit()'],
                'choices' => [20 => 20, 50 => 50, 100 => 100]
            ])
            //END_PER_PAGE
            //START_users
            ->add('createdBy', EntityType::class, [
                'class' => User::class,
                'choice_value' => 'id',
                'choice_label' => 'name',
                'query_builder' => function (UserRepository $repository) {
                    return $repository
                        ->newCriteriaActiveQb()
                        ->orderBy('entity.name');
                },
                'label' => 'Criado por',
                'label_attr' => ['class' => 'mt-1'],
                'attr' => ['class' => 'form-select select2'],
                'placeholder' => 'Escolha um usuário',
                'required' => false
            ])
            ->add('updatedBy', EntityType::class, [
                'class' => User::class,
                'choice_value' => 'id',
                'choice_label' => 'name',
                'query_builder' => function (UserRepository $repository) {
                    return $repository
                        ->newCriteriaActiveQb()
                        ->orderBy('entity.name');
                },
                'label' => 'Atualizado por',
                'label_attr' => ['class' => 'mt-1'],
                'attr' => ['class' => 'form-select select2'],
                'placeholder' => 'Escolha um usuário',
                'required' => false
            ])
            ->add('deletedBy', EntityType::class, [
                'class' => User::class,
                'choice_value' => 'id',
                'choice_label' => 'name',
                'query_builder' => function (UserRepository $repository) {
                    return $repository
                        ->newCriteriaActiveQb()
                        ->orderBy('entity.name');
                },
                'label' => 'Deletado por',
                'label_attr' => ['class' => 'mt-1'],
                'attr' => ['class' => 'form-select form-control-sm select2'],
                'placeholder' => 'Escolha um usuário',
                'required' => false
            ])
            //END_users
            //START_TIMESTAMPS
            ->add('createdAtStart', DateTimePickerType::class, [
                'label' => 'Criado de',
                'label_attr' => ['class' => 'mt-1'],
                'attr' => [
                    'class' => 'flatpickr_timed flatpickr-input',
                    'placeholder' => 'Criado a partir de...',
                    'autocomplete' => 'off'],
                'required' => false
            ])
            ->add('createdAtEnd', DateTimePickerType::class, [
                'label' => 'Criado até',
                'label_attr' => ['class' => 'mt-1'],
                'attr' => [
                    'class' => 'flatpickr_timed flatpickr-input',
                    'placeholder' => 'Criado até...',
                    'autocomplete' => 'off'],
                'required' => false
            ])
            ->add('updatedAtStart', DateTimePickerType::class, [
                'label' => 'Atualizado de',
                'label_attr' => ['class' => 'mt-1'],
                'attr' => [
                    'class' => 'flatpickr_timed flatpickr-input',
                    'placeholder' => 'Atualizado a partir de...',
                    'autocomplete' => 'off'],
                'required' => false
            ])
            ->add('updatedAtEnd', DateTimePickerType::class, [
                'label' => 'Atualizado até',
                'label_attr' => ['class' => 'mt-1'],
                'attr' => [
                    'class' => 'flatpickr_timed flatpickr-input',
                    'placeholder' => 'Atualizado até...',
                    'autocomplete' => 'off'],
                'required' => false
            ])
            ->add('deletedAtStart', DateTimePickerType::class, [
                'label' => 'Deletado de',
                'label_attr' => ['class' => 'mt-1'],
                'attr' => [
                    'class' => 'flatpickr_timed flatpickr-input',
                    'placeholder' => 'Atualizado a partir de...',
                    'autocomplete' => 'off'],
                'required' => false
            ])
            ->add('deletedAtEnd', DateTimePickerType::class, [
                'label' => 'Deletado até',
                'label_attr' => ['class' => 'mt-1'],
                'attr' => [
                    'class' => 'flatpickr_timed flatpickr-input',
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