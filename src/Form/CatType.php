<?php

namespace App\Form;

use App\Entity\Cat;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CatType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('image', FileType::class, [
                'mapped' => false
            ])
            ->add('name')
            ->add('dob')
            ->add('city')
            ->add('breed')
            ->add('gender')
            ->add('coat')
            ->add('eyeColor')
            ->add('weight')
            ->add('size')
            ->add('description')
            // ->add('review')
            ->add('owner');
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Cat::class,
        ]);
    }
}
