<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

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
                        'message' => 'You should agree to our terms.',
                    ]),
                ],
            ])
            ->add('plainPassword', PasswordType::class, [
                'attr' => array('class' => 'form-control'),
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a password',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Your password should be at least {{ limit }} characters',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
