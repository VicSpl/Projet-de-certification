<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class, array('attr' => array('class' => 'form-control')))
            ->add('firstname', TextType::class, array('attr' => array('class' => 'form-control')))
            ->add('lastname', TextType::class, array('attr' => array('class' => 'form-control')))
            ->add('address', TextType::class, array('attr' => array('class' => 'form-control')))
            ->add('zipCode', TextType::class, array('attr' => array('class' => 'form-control')))
            ->add('city', TextType::class, array('attr' => array('class' => 'form-control')))
            ->add('phone', TextType::class, array('attr' => array('class' => 'form-control')))
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'Vous devez accépter les conditions d\'utlisation',
                    ]),
                ],
            ])
            // add password with double input
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'The password fields must match.',
                'options' => ['attr' => ['class' => 'password-field form-control']],
                'required' => true,
                'first_options'  => ['label' => 'Mot de passe *'],
                'second_options' => ['label' => 'Comfirmation mot de passe*'],
            ])
            ->add('licenceJudge', FileType::class, [
                'mapped' => false, 'attr' => array('class' => 'form-control-file')
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
