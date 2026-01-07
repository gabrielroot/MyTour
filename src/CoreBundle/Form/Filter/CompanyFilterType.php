<?php

namespace MyTour\CoreBundle\Form\Filter;

use MyTour\CoreBundle\Entity\Filter\CompanyFormFilter;
use MyTour\CoreBundle\Form\Filter\AbstractFormType;
use MyTour\ExcursionBundle\Entity\Filter\TripFormFilter;
use MyTour\UserBundle\Entity\Organizer;
use MyTour\UserBundle\Repository\OrganizerRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CompanyFilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nome:',
                'attr' => [ 'placeholder' => 'Informe o nome'],
                'required' => false
            ])
            ->add('fantasyName', TextType::class, [
                'label' => 'Nome fantasia:',
                'attr' => [ 'placeholder' => 'Informe o nome'],
                'required' => false
            ])
            ->add('cnpj', TextType::class, [
                'label' => 'CNPJ:',
                'attr' => [ 'placeholder' => 'Informe o CNPJ'],
                'required' => false
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CompanyFormFilter::class
        ]);
    }

    public function getParent(): string
    {
        return AbstractFormType::class;
    }
}