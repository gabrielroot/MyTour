<?php

namespace MyTour\ExcursionBundle\Form\Filter;

use MyTour\CoreBundle\Form\Custom\DateTimePickerType;
use MyTour\CoreBundle\Form\Filter\AbstractFormType;
use MyTour\ExcursionBundle\Entity\Filter\TripFormFilter;
use MyTour\UserBundle\Entity\Organizer;
use MyTour\UserBundle\Entity\Traveler;
use MyTour\UserBundle\Repository\OrganizerRepository;
use MyTour\UserBundle\Repository\TravelerRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TripFilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Título:',
                'attr' => [ 'placeholder' => 'Informe o título'],
                'required' => false
            ])
            ->add('description', TextType::class, [
                'label' => 'Descrição:',
                'attr' => [ 'placeholder' => 'Informe a descrição'],
                'required' => false
            ])
            ->add('capacity', NumberType::class, [
                'label' => 'Capacidade:',
                'attr' => [ 'placeholder' => 'Informe a capacidade'],
                'required' => false
            ])
            ->add('dateStart', DateTimePickerType::class, [
                'label' => 'Data de início:',
                'label_attr' => ['class' => 'mt-1'],
                'attr' => [
                    'class' => 'flatpickr_timed flatpickr-input',
                    'placeholder' => 'A viagem se inicia em...',
                    'autocomplete' => 'off'],
                'required' => false
            ])
            ->add('dateEnd', DateTimePickerType::class, [
                'label' => 'Data de término:',
                'label_attr' => ['class' => 'mt-1'],
                'attr' => [
                    'class' => 'flatpickr_timed flatpickr-input',
                    'placeholder' => 'A viagem se termina em...',
                    'autocomplete' => 'off'],
                'required' => false
            ])
            ->add('price', NumberType::class, [
                'label' => 'Preço:',
                'attr' => [ 'placeholder' => 'Informe o preço'],
                'required' => false
            ])
            ->add('traveler', EntityType::class, [
                'label' => 'Viajante:',
                'placeholder' => 'Informe o viajante',
                'attr' => ['class' => 'form-select form-control-sm select2'],
                'class' => Traveler::class,
                'choice_value' => 'id',
                'choice_label' => 'name',
                'query_builder' => function (TravelerRepository $repository) {
                    return $repository
                        ->newCriteriaActiveQb()
                        ->orderBy('entity.name');
                },
                'required' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => TripFormFilter::class
        ]);
    }

    public function getParent(): string
    {
        return AbstractFormType::class;
    }
}