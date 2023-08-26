<?php

namespace App\Form;

use App\Entity\Utilisateur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\PasswordUpdateType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;

// use Symfony\Component\Validator\Constraints as Assert;

class ModificationPasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('plainPassword', RepeatedType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'type' => PasswordType::class,
                'invalid_message' => 'Les mots de passe doivent être identique',
                'options' =>[
                    'row_attr'  =>  ['class' => 'con-form', 'id' => ''],
                    'attr' => ['autocomplete' => 'password'],
                   ],
                   //creat form label
                'first_options' => ['label' => 'mot de passe actuel'],
                'second_options' => ['label' => 'confirmation du mot de passe'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a password',
                    ]),
                ],
            ])
            ->add('newPassword', PasswordType::class, [
                'row_attr'  =>  ['class' => 'con-form', 'id' => ''],
                'label' => 'nouveau mot de passe',
                'constraints' => [new NotBlank([
                    'message' => 'Please enter a password',
                ]),
                new Length([
                    'min' => 6,
                    'minMessage' => 'Your password should be at least {{ limit }} characters',
                    // max length allowed by Symfony for security reasons
                    'max' => 4096,
                ]),]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // No data_class required.
        ]);
    }
}
