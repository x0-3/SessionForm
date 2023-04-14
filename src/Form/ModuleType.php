<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Module;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ModuleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name',TextType::class, array(
                'label' => false,
                'attr' => array(
                    'placeholder' => 'Name',
                    'class' => 'w-80 mb-5 p-1.5 rounded-lg',

                )
            ))

            // ->add('category', EntityType::class,[
            //     'class'=>Category::class,
            //     'choice_label' => 'name'])

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
            'data_class' => Module::class,
        ]);
    }
}
