<?php

namespace App\Form;

use App\Entity\Comment;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('note')
            ->add('en_panne',CheckboxType::class, [
                'row_attr'  =>  ['class' => 'form-checkbox', 'id' => ''],
                'label_attr' => ['label' => 'en panne']
            ])
            ->add('n_existe__plus',CheckboxType::class, [
                'row_attr'  =>  ['class' => 'form-checkbox', 'id' => ''],
                'label_attr' => ['label' => 'n’existe plus']
            ])
            ->add('acces_handicape',CheckboxType::class, [
                'row_attr'  =>  ['class' => 'form-checkbox', 'id' => ''],
                'label_attr' => ['label' => 'accès handicapé']
            ])
            ->add('autre',CheckboxType::class, [
                'row_attr'  =>  ['class' => 'form-checkbox', 'id' => ''],
                'label_attr' => ['label' => 'autre'],
                'attr' => ['onchange' => 'activateTextarea()']
            ])
            ->add('commentaire',null, [
                'attr'  =>  ['class' => 'form-inactive','id' => 'commentaire', 'disabled' => 'true' ],
            ])
            ->add('date_commentaire')
            ->add('id_toilette')
            ->add('id_utilisateur')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Comment::class,
        ]);
    }
}
