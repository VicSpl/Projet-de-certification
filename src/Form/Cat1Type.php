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
                'mapped' => false,
                'label' => 'Image',
                'attr' =>  [
                    'class' => 'form-control-file'
                ]
            ])
            ->add('name', TextType::class, array(
                'attr' => array(
                    'class' => 'form-control'
                ),
                'label' => 'Nom'
            ))
            ->add('dob', DateType::class, array(
                'widget' => 'single_text',
                'attr' => array(
                    // 'class' => 'form-control'
                    'class' => 'form-control input-inline datetimepicker',
                    'data-provide' => 'datetimepicker',
                    'html5' => false,
                ),
                'label' => 'Date de naissance'
            ))
            ->add('city', TextType::class, array(
                'attr' => array(
                    'class' => 'form-control'
                ),
                'label' => 'Ville'
            ))
            ->add('breed', TextType::class, array(
                'attr' => array(
                    'class' => 'form-control'
                ),
                'label' => 'Race'
            ))
            ->add(
                'gender',
                ChoiceType::class,
                [
                    'choices'  => [
                        'Mâle' => 'Mâle',
                        'Femelle' => 'Femelle'
                    ], 'attr' => array(
                        'class' => 'form-control'
                    ),
                    'label' => 'Genre'
                ]
            )
            ->add('coat', TextType::class, array(
                'attr' => array(
                    'class' => 'form-control'
                ),
                'label' => 'Robe'
            ))
            ->add('eyeColor', TextType::class, array(
                'attr' => array(
                    'class' => 'form-control'
                ),
                'label' => 'Couleur des yeux'
            ))
            ->add('weight', NumberType::class, array(
                'attr' => array(
                    'class' => 'form-control',
                    'step' => 0.1
                ),
                'label' => 'Poids'
            ))
            ->add('size', NumberType::class, array(
                'attr' => array(
                    'class' => 'form-control',
                    'step' => 0.1
                ),
                'label' => 'Taille'
            ))
            ->add('description', TextareaType::class, array(
                'attr' => array(
                    'class' => 'form-control'
                ),
                'label' => 'Description'
            ))
            ->add('genealogyFile', FileType::class, [
                'mapped' => false,
                'attr' => array('required' => true, 'class' => 'form-control-file'),
                'label' => 'Fichier de généalogie'
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
