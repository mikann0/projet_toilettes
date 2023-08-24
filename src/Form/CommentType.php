<?php

namespace App\Form;

use App\Entity\Comment;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('note',null, [
                'row_attr'  =>  ['class' => 'filtrer_note', 'id' => ''],
            ])
            ->add('enPanne',CheckboxType::class, [
                'row_attr'  =>  ['class' => 'form-checkbox', 'id' => 'id'],
                'required' => false,
            ])
            ->add('nExistePlus',CheckboxType::class, [
                'row_attr'  =>  ['class' => 'form-checkbox', 'id' => ''],
                'required' => false,
                ])
            ->add('accesHandicape',CheckboxType::class, [
                'row_attr'  =>  ['class' => 'form-checkbox', 'id' => ''],
                'required' => false,
                ])
            ->add('commentaire',TextareaType::class, [
                'attr'  =>  ['class' => 'form-inactive','id' => 'commentaire', 'disabled' => 'true' ],
                'required' => false,
                ])
            // ->add('dateCommentaire')
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
