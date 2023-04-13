<?php

namespace App\Form;

use App\Entity\Module;
use App\Entity\Program;
use App\Entity\Session;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProgramType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('duree', IntegerType::class, array(
                'label' => false,
                'attr' => array(
                    'placeholder' => 'duree',
                    'class' => 'w-80 mb-5 p-1.5 rounded-lg',

                )
            ))

            // ->add('session', EntityType::class,
            // [
            //     'class'=>Session::class,
            //     'choice_label' => function (Session $session){
            //         return $_GET['id'];;
            //     }
            // ])

            // ->add('session', EntityType::class,[
            //     'class'=>Session::class,
            //     'choice_label' => 'name'])

            
            ->add('session',EntityType::class,
            [
                'class' => Session::class,
                'choice_label' => function ($session) {
                    return ($session->getId()); 
                    
                }
                 
            ]
            )

            ->add('module', EntityType::class,[
                'class'=>Module::class,
                'choice_label' => 'name'])

            ->add('submit',SubmitType::class, array(
                'attr' => array(
                    'class' => 'justify-center w-28 mb-5 p-1.5 rounded-lg bg-gray-500',
                )
            ))
        ;


    
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Program::class,
        ]);
    }
}
