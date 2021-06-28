<?php

namespace App\Form;

// On utilise l'entité Message car un message interne est très proche
// de la composition d'un mail
use App\Entity\Message;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        // Object tu mail
            ->add('subject', ChoiceType::class, [
                'attr' => ['class' => 'form-control mt-3'], 
                'label' => 'Motif/Question',
                // balise select de choix
                'choices'  => [
                    'Problème avec un particuler' => 'Problème avec un particuler',
                    'Autre question' => 'Autre question'
                ]
            ])
            // textarea pour le corps du mail
            ->add('content', TextareaType::class, ['attr' => ['class' => 'form-control mt-3', 'placeholder' => 'Ecriver votre message ici', 'cols' => '30', 'rows' => '5'], 'label' => 'Message'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Message::class,
        ]);
    }
}
