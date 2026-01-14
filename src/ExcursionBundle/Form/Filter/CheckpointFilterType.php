<?php

namespace MyTour\ExcursionBundle\Form\Filter;

use MyTour\CoreBundle\Form\Custom\DateTimePickerType;
use MyTour\CoreBundle\Form\Filter\AbstractFormType;
use MyTour\ExcursionBundle\Entity\Filter\CatalogFormFilter;
use MyTour\ExcursionBundle\Entity\Filter\CheckpointFormFilter;
use MyTour\ExcursionBundle\Entity\Filter\TripFormFilter;
use MyTour\ExcursionBundle\Entity\Trip;
use MyTour\ExcursionBundle\Repository\TripRepository;
use MyTour\UserBundle\Entity\Organizer;
use MyTour\UserBundle\Entity\Traveler;
use MyTour\UserBundle\Repository\OrganizerRepository;
use MyTour\UserBundle\Repository\TravelerRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CheckpointFilterType extends AbstractType
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
            ->add('location', NumberType::class, [
                'label' => 'Local:',
                'attr' => [ 'placeholder' => 'Nome da cidade, ponto turístico, etc.'],
                'required' => false
            ])
            ->add('estimatedDateTime', DateTimePickerType::class, [
                'label' => 'Data de início:',
                'label_attr' => ['class' => 'mt-1'],
                'attr' => [
                    'class' => 'flatpickr_timed flatpickr-input',
                    'placeholder' => 'A viagem se inicia em...',
                    'autocomplete' => 'off'],
                'required' => false
            ])
            ->add('visitedDateTime', DateTimePickerType::class, [
                'label' => 'Data de término:',
                'label_attr' => ['class' => 'mt-1'],
                'attr' => [
                    'class' => 'flatpickr_timed flatpickr-input',
                    'placeholder' => 'A viagem termina em...',
                    'autocomplete' => 'off'],
                'required' => false
            ])
            ->add('trip', EntityType::class, [
                'label' => 'Viagem:',
                'placeholder' => 'Selecione a viagem',
                'attr' => ['class' => 'form-select form-control-sm select2'],
                'class' => Trip::class,
                'choice_value' => 'id',
                'choice_label' => 'title',
                'query_builder' => function (TripRepository $repository) {
                    return $repository
                        ->newCriteriaActiveQb()
                        ->orderBy('entity.title');
                },
                'required' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CheckpointFormFilter::class
        ]);
    }

    public function getParent(): string
    {
        return AbstractFormType::class;
    }
}