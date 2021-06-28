<?php

namespace App\Form;

use App\Entity\Content;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('articleTitle', TextType::class, [
                'attr' => ['class' => 'form-control'],
                'label' => 'Titre de l\'article', 'required' => false
            ])
            ->add('articleContent',  TextareaType::class, [
                'attr' => ['class' => 'form-control'],
                'label' => 'Contenu de l\'article', 'required' => false
            ])
            ->add('page', TextType::class, [
                'attr' => ['class' => 'form-control'],
                'label' => 'Page de l\'article*', 'required' => true
            ])
            ->add('picture',  FileType::class, [
                'data_class' => null,
                'attr' => ['class' => 'form-control-file'],
                'label' => 'Illustration de l\'article', 'required' => false
            ])
            
            ->add('link',  TextType::class, [
                'attr' => ['class' => 'form-control'],
                'label' => 'Lien externe', 'required' => false
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Content::class,
        ]);
    }
}
