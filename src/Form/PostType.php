<?php

namespace App\Form;

use App\Entity\Post;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PostType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', null, [
                'label'     => 'Titre de l\'article'
            ])
            ->add('description')
            ->add('posted', null, [
                'label' => 'Voulez-vous le poster?, si oui, cochez la case'
            ])
            ->add('user', EntityType::class, [
                'label'          => 'Choissez l\'administrateur',
                'required'       => false,
                'class'          => User::class,
                'choice_label'   => 'email',
                'multiple'       => false
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Post::class,
        ]);
    }
}
