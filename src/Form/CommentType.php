<?php

namespace App\Form;

use App\Entity\Comment;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('note')
            ->add('enPanne',ChoiceType::class, [
                'row_attr'  =>  ['class' => 'form-checkbox', 'id' => ''],
                'label_attr' => ['label' => 'en panne'],
                'choices' => [
                    'No' => 0,
                    'Yes' => 1,
                ],
                'expanded' => true,
                'multiple' => false,
            ])
            ->add('nExistePlus',ChoiceType::class, [
                'row_attr'  =>  ['class' => 'form-checkbox', 'id' => ''],
                'label_attr' => ['label' => 'n’existe plus'],
                'choices' => [
                    'No' => 0,
                    'Yes' => 1,
                ],
                'expanded' => true,
                'multiple' => false,
            ])
            ->add('accesHandicape',ChoiceType::class, [
                'row_attr'  =>  ['class' => 'form-checkbox', 'id' => ''],
                'label_attr' => ['label' => 'accès handicapé'],
                'choices' => [
                    'No' => 0,
                    'Yes' => 1,
                ],
                'expanded' => true,
                'multiple' => false,
            ])
            ->add('commentaire',null, [
                'attr'  =>  ['class' => 'form-inactive','id' => 'commentaire', 'disabled' => 'true' ],
            ])
            ->add('dateCommentaire')
           // ->add('id_toilette')
           // ->add('id_utilisateur')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Comment::class,
        ]);
    }
}
