<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
// use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class User1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType ::class, [
                'label' => 'Email', 'attr' => ['class' => 'form-control']
             ])
            // ->add('roles', CollectionType::class)
            // ->add('password', TextType ::class, [
            //    'label' => 'Mot de passe', 'attr' => ['class' => 'password-field form-control']
            // ])
            ->add('firstname', TextType ::class, [
                'label' => 'Prénom', 'attr' => ['class' => 'form-control']
             ])
            ->add('lastname', TextType ::class, [
                'label' => 'Nom', 'attr' => ['class' => 'form-control']
             ])
            ->add('address', TextType ::class, [
                'label' => 'Adresse', 'attr' => ['class' => 'form-control']
             ])
            ->add('zipCode', TextType ::class, [
                'label' => 'Code postale', 'attr' => ['class' => 'form-control']
             ])
            ->add('city', TextType ::class, [
                'label' => 'Ville', 'attr' => ['class' => 'form-control']
             ])
            ->add('phone', TextType ::class, [
                'label' => 'Téléphone', 'attr' => ['class' => ' form-control']
             ])
            // ->add('active')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
