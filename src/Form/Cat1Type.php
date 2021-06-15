<?php

namespace App\Form;

use App\Entity\Cat;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Cat1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('image', FileType::class, [
                'mapped' => false
            ])
            ->add('name', TextType::class, array(
                'attr' => array(
                    'class' => 'form-control'
                )
            ))
            ->add('dob', DateType::class, array(
                'attr' => array(
                    // 'class' => 'form-control'
                )
            ))
            ->add('city', TextType::class, array(
                'attr' => array(
                    'class' => 'form-control'
                )
            ))
            ->add('breed', TextType::class, array(
                'attr' => array(
                    'class' => 'form-control'
                )
            ))
            ->add(
                'gender',
                ChoiceType::class,
                [
                    'choices'  => [
                        'Mâle' => 'Mâle',
                        'Femelle' => 'Femelle'
                    ], 'attr' => array(
                        'class' => 'form-select'
                    )
                ]
            )
            ->add('coat', TextType::class, array(
                'attr' => array(
                    'class' => 'form-control'
                )
            ))
            ->add('eyeColor', TextType::class, array(
                'attr' => array(
                    'class' => 'form-control'
                )
            ))
            ->add('weight', NumberType::class, array(
                'attr' => array(
                    'class' => 'form-control',
                    'step' => 0.1
                )
            ))
            ->add('size', NumberType::class, array(
                'attr' => array(
                    'class' => 'form-control',
                    'step' => 0.1
                )
            ))
            ->add('description', TextareaType::class, array(
                'attr' => array(
                    'class' => 'form-control'
                )
            ))
            ->add('certificat', FileType::class, [
                'mapped' => false,
                'attr' => array('required' => true)
            ]);
        // ->add('review')
        //->add('owner');
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Cat::class,
        ]);
    }
}
