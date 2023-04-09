<?php

namespace App\Form;

use App\Entity\Session;
use App\Entity\Stagiaire;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StagiaireType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, array(
                'label' => false,
                'attr' => array(
                    'placeholder' => 'Name',
                    'class' => 'w-80 mb-5 mt-5 p-1.5 rounded-lg',

                )
            ))

            ->add('lastName', TextType::class, array(
                'label' => false,
                'attr' => array(
                    'placeholder' => 'LastName',
                    'class' => 'w-80 mb-5 p-1.5 rounded-lg',

                )
            ))

            ->add('gender', TextType::class, array(
                'label' => false,
                'attr' => array(
                    'placeholder' => 'Gender',
                    'class' => 'w-80 mb-5 p-1.5 rounded-lg',

                )
            ))

            ->add('birthday', DateType::class, array(
                'attr' => array(
                    'placeholder' => 'Adresse',
                    'class' => 'w-80 mb-5 p-1.5 rounded-lg',

                )
            )
            )

            ->add('adresse', TextType::class, array(
                'label' => false,
                'attr' => array(
                    'placeholder' => 'Adresse',
                    'class' => 'w-80 mb-5 p-1.5 rounded-lg',

                )
            ))

            ->add('city', TextType::class, array(
                'label' => false,
                'attr' => array(
                    'placeholder' => 'city',
                    'class' => 'w-80 mb-5 p-1.5 rounded-lg',

                )
            ))

            ->add('zipCode', TextType::class, array(
                'label' => false,
                'attr' => array(
                    'placeholder' => 'ZipCode',
                    'class' => 'w-80 mb-5 p-1.5 rounded-lg',

                )
            ))

            ->add('email', EmailType::class, array(
                'label' => false,
                'attr' => array(
                    'placeholder' => 'Email',
                    'class' => 'w-80 mb-5 p-1.5 rounded-lg',

                )
            ))

            ->add('tel', TextType::class, array(
                'label' => false,
                'attr' => array(
                    'placeholder' => 'Tel',
                    'class' => 'w-80 mb-5 p-1.5 rounded-lg',

                )
            ))
            

            ->add('stagiaire_session', EntityType::class, [
                'label' => 'Sessions : ',
                'class' => Session::class,
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => true,
            ])

            ->add('submit', SubmitType::class, array(
                'attr' => array(
                    'class' => 'justify-center w-28 mb-5 mt-5 p-1.5 rounded-lg bg-gray-500',
                )
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Stagiaire::class,
            // 'data_class' => Parent_::class,
        ]);
    }
}
