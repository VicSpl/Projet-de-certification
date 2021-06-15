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
// use Symfony\Component\Validator\Constraints\Length;
// use Symfony\Component\Validator\Constraints\NotBlank;
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
            // ->add('active')
            ->add('agreeTerms', CheckboxType::class, [
                // 'attr' => array('class' => 'form-check-input'),
                // 'label_attr' => array('class' => 'form-check-label'),
                // 'row_attr' => array('class' => 'form-check'),
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'Vous devez accépter les conditions d\'utlisation',
                    ]),
                ],
            ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'The password fields must match.',
                'options' => ['attr' => ['class' => 'password-field form-control']],
                'required' => true,
                'first_options'  => ['label' => 'Mot de passe *'],
                'second_options' => ['label' => 'Comfirmation mot de passe*'],
            ])
            ->add('licenceJudge', FileType::class, [
                'mapped' => false
            ]);
            // ->add('plainPassword', PasswordType::class, [
            //     'attr' => array('class' => 'form-control'),
            //     // instead of being set onto the object directly,
            //     // this is read and encoded in the controller
            //     'mapped' => false,
            //     'constraints' => [
            //         new NotBlank([
            //             'message' => 'Veuillez définir un mot de passe',
            //         ]),
            //         new Length([
            //             'min' => 6,
            //             'minMessage' => 'Votre mot de passe doit contenir au moins {{ limit }} characters',
            //             // max length allowed by Symfony for security reasons
            //             'max' => 4096,
            //         ]),
            //     ],
            // ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
