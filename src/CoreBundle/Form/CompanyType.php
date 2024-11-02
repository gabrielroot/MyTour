<?php

namespace MyTour\CoreBundle\Form;

use MyTour\CoreBundle\Entity\Company;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class CompanyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nome:',
                'attr' => [ 'placeholder' => 'Informe o nome'],
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'Por favor, informe um valor.',
                    ]),
                    new Assert\Length([
                        'min' => 10,
                        'minMessage' => 'O nome precisa ter ao menos {{ limit }} caracteres.',
                        'maxMessage' => 'O nome não pode ter mais que {{ limit }} caracteres.',
                        'max' => 150,
                    ]),
                ],
            ])
            ->add('fantasyName', TextType::class, [
                'label' => 'Nome fantasia:',
                'attr' => [ 'placeholder' => 'Informe o nome fantasia'],
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'Por favor, informe um valor.',
                    ]),
                    new Assert\Length([
                        'min' => 10,
                        'minMessage' => 'Este campo precisa ter ao menos {{ limit }} caracteres.',
                        'maxMessage' => 'Este campo não pode ter mais que {{ limit }} caracteres.',
                        'max' => 150,
                    ]),
                ],
            ])

            ->add('cnpj', TextType::class, [
                'label' => 'CNPJ:',
                'attr' => [ 'placeholder' => 'Informe o CNPJ'],
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'Por favor, informe um valor.',
                    ]),
                    new Assert\Length([
                        'min' => 14,
                        'exactMessage' => 'Este campo precisa ter exatamente {{ limit }} caracteres.',
                        'max' => 14,
                    ]),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Company::class
        ]);
    }
}