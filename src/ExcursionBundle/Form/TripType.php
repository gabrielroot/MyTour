<?php

namespace MyTour\ExcursionBundle\Form;

use MyTour\CoreBundle\Form\Custom\DateTimePickerType;
use MyTour\CoreBundle\Utils\Enum\RoleEnum;
use MyTour\ExcursionBundle\Entity\Catalog;
use MyTour\ExcursionBundle\Entity\Trip;
use MyTour\ExcursionBundle\Repository\CatalogRepository;
use MyTour\UserBundle\Entity\Organizer;
use MyTour\UserBundle\Repository\OrganizerRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class TripType extends AbstractType
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
            ->add('price', NumberType::class, [
                'label' => 'Preço:',
                'attr' => [ 'placeholder' => 'Informe o valor praticado'],
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'Por favor, informe um valor.',
                    ]),
                    new Assert\GreaterThan([
                        'value' => 0,
                        'message' => 'O preço deve ser maior que {{ value }}.'
                    ]),
                ],
            ])
            ->add('capacity', NumberType::class, [
                'label' => 'Preço:',
                'attr' => [ 'placeholder' => 'Informe a capacidade de pessoas'],
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'Por favor, informe um valor.',
                    ]),
                    new Assert\GreaterThan([
                        'value' => 1,
                        'message' => 'A quantidade deve ser maior que {{ value }}.'
                    ]),
                ],
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
                    'placeholder' => 'A viagem termina em...',
                    'autocomplete' => 'off'],
                'required' => false
            ])
            ->add('catalog', EntityType::class, [
                'label' => 'Catálogo:',
                'placeholder' => 'Selecione o catálogo da viagem',
                'attr' => ['class' => 'form-select form-control-sm select2'],
                'class' => Catalog::class,
                'choice_value' => 'id',
                'choice_label' => 'title',
                'query_builder' => function (CatalogRepository $repository) {
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
            'data_class' => Trip::class
        ]);
    }
}