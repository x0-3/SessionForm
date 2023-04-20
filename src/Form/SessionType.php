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

                // the collection waits for the element that will go into the form
                // not mandatory for it to be another form
                'entry_type' => ProgramType::class,
                'prototype' => true,

                // allows to add new elements into the Session entity that will be persisted thanks to cascade_persist on the programs element 
                // it will activate a prototype date that will be an HTML attribute that can be manipulated in JavaScript 
                'allow_add' => true, // allow to add a new element
                'allow_delete' => true, // allow to delete an element
                'by_reference' => false, // mandatory : Session doesn't have a set Programe but program has a setSession
                // Program is the owner of the relation 
                // to avoid a mapping false we are obligated to set a by_reference
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
