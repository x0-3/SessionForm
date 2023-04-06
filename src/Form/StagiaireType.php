<?php

namespace App\Form;

use App\Entity\Stagiaire;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StagiaireType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class)
            ->add('lastName', TextType::class)
            ->add('gender', TextType::class)
            ->add('birthday', DateType::class)
            ->add('adresse', TextType::class)
            ->add('city', TextType::class)
            ->add('zipCode', TextType::class)
            ->add('email', TextType::class)
            ->add('tel', TextType::class)
            ->add('submit', SubmitType::class)

            // ->add('stagiaire_session')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Stagiaire::class,
        ]);
    }
}
