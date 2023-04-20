<?php

namespace App\Form;

use App\Entity\Session;
use App\Entity\Stagiaire;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SessionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, array(
                'label' => false,
                'attr' => array(
                    'placeholder' => 'Name',
                    'class' => 'w-80 mb-5 p-1.5 rounded-lg',

                )
            ))
            ->add('beginDate', DateType::class, array(
                'attr' => array(
                    'class' => 'w-80 mb-5 p-1.5 rounded-lg',

                )
            ))
            ->add('endDate', DateType::class, array(
                'attr' => array(
                    'class' => 'w-80 mb-5 p-1.5 rounded-lg',

                )
            ))
            ->add('nb_place', IntegerType::class, array(
                'label' => false,
                'attr' => array(
                    'placeholder' => 'number of place',
                    'class' => 'w-80 mb-5 p-1.5 rounded-lg',

                )
            ))

            ->add('programs', CollectionType::class, [

                // la collection attend l'element qu'elle entrera dans le form 
                // pas obligatoire que ce soit un autres form
                'entry_type' => ProgramType::class,
                'prototype' => true,

                // autoriser l'ajout de nouveau element dans l'entiter session qui serons persiter grace au cascade_persist sur l'élement Programs
                // ca va activer un date prototype qui sera un attribut html qu'on pourra manipuler en JavaScript
                'allow_add' => true, // allow to add a new element
                'allow_delete' => true, // allow to delete an element
                'by_reference' => false, // obligatoire Session n'a pas de setPrograms mais c'est program qui contient setSession
                // Program est proprietaire de la relation 
                // pour eviter un mapping false on est obligé de rajouter un by_reference
            ])

            // ->add('stagiaire_session', EntityType::class, [
            //     'label' => 'interns : ',
            //     'class' => Stagiaire::class,
            //     'choice_label' => 'name',
            //     'multiple' => true,
            //     'expanded' => true,
            // ])

            ->add('submit', SubmitType::class, array(
                'attr' => array(
                    'class' => 'justify-center w-28 mb-5 p-1.5 rounded-lg bg-gray-500',
                )
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Session::class,
        ]);
    }
}
