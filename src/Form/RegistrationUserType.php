<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class RegistrationUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email',null, ['label'=>'Email'])
            ->add('username',null, ['label'=>'Nom d\'utilisateur'])
            ->add('password', PasswordType::class, ['label'=>'Mot de passe'])
            ->add('confirm_password', PasswordType::class, ['label'=>'Confirmez votre Mot de passe'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
