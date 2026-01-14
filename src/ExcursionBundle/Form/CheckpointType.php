<?php

namespace MyTour\ExcursionBundle\Form;

use MyTour\CoreBundle\Form\Custom\DateTimePickerType;
use MyTour\CoreBundle\Utils\Enum\RoleEnum;
use MyTour\ExcursionBundle\Entity\Catalog;
use MyTour\ExcursionBundle\Entity\Checkpoint;
use MyTour\ExcursionBundle\Entity\Trip;
use MyTour\ExcursionBundle\Repository\CatalogRepository;
use MyTour\ExcursionBundle\Repository\TripRepository;
use MyTour\UserBundle\Entity\Organizer;
use MyTour\UserBundle\Repository\OrganizerRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class CheckpointType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Título:',
                'attr' => [ 'placeholder' => 'Informe o título'],
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'Por favor, informe um valor.',
                    ]),
                    new Assert\Length([
                        'min' => 10,
                        'minMessage' => 'O título precisa ter ao menos {{ limit }} caracteres.',
                        'maxMessage' => 'O título não pode ter mais que {{ limit }} caracteres.',
                        'max' => 150,
                    ]),
                ],
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Descrição:',
                'attr' => [ 'placeholder' => 'Informe a descrição', 'rows' => 5 ],
                'required' => false,
                'constraints' => [
                    new Assert\Length([
                        'maxMessage' => 'A descrição não pode ter mais que {{ limit }} caracteres.',
                        'max' => 255,
                    ]),
                ],
            ])
            ->add('location', TextType::class, [
                'label' => 'Local:',
                'attr' => [ 'placeholder' => 'Nome da cidade, ponto turístico, etc.'],
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'Por favor, informe um nome.',
                    ]),
                ],
            ])
            ->add('longitude', HiddenType::class, [
                'label' => 'Longitude:',
                'attr' => [ 'placeholder' => 'Informe a longitude'],
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'Por favor, informe um valor.',
                    ])
                ],
            ])
            ->add('latitude', HiddenType::class, [
                'label' => 'Longitude:',
                'attr' => [ 'placeholder' => 'Informe a latitude'],
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'Por favor, informe um valor.',
                    ])
                ],
            ])
            ->add('estimatedDateTime', DateTimePickerType::class, [
                'label' => 'Previsão de chegada:',
                'label_attr' => ['class' => 'mt-1'],
                'attr' => [
                    'class' => 'flatpickr_timed flatpickr-input',
                    'placeholder' => 'O local será visitado em...',
                    'autocomplete' => 'off'],
                'required' => false
            ])
            ->add('visitedDateTime', DateTimePickerType::class, [
                'label' => 'Momento da visita:',
                'label_attr' => ['class' => 'mt-1'],
                'attr' => [
                    'class' => 'flatpickr_timed flatpickr-input',
                    'placeholder' => 'O momento em que o lugar foi visitado...',
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
            'data_class' => Checkpoint::class
        ]);
    }
}