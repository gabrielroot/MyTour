<?php

namespace MyTour\ExcursionBundle\Form\Filter;

use MyTour\CoreBundle\Form\Filter\AbstractFormType;
use MyTour\ExcursionBundle\Entity\Filter\CatalogFormFilter;
use MyTour\UserBundle\Entity\Organizer;
use MyTour\UserBundle\Repository\OrganizerRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CatalogFilterType extends AbstractType
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
            ->add('price', NumberType::class, [
                'label' => 'Preço:',
                'attr' => [ 'placeholder' => 'Informe o preço'],
                'required' => false
            ])
            ->add('available', ChoiceType::class, [
                'choices' => ['Não' => 0, 'Sim' => 1],
                'label' => 'Disponível?',
                'attr' => ['class' => 'form-select form-control-sm'],
                'placeholder' => 'Selecione',
                'required' => false
            ])
            ->add('organizer', EntityType::class, [
                'label' => 'Organizador:',
                'placeholder' => 'Informe o nível de acesso',
                'attr' => ['class' => 'form-select form-control-sm select2'],
                'class' => Organizer::class,
                'choice_value' => 'id',
                'choice_label' => 'name',
                'query_builder' => function (OrganizerRepository $repository) {
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
            'data_class' => CatalogFormFilter::class
        ]);
    }

    public function getParent(): string
    {
        return AbstractFormType::class;
    }
}