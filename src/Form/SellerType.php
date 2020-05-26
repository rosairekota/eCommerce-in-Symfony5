<?php

namespace App\Form;

use App\Entity\Product;
use App\Entity\Seller;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class SellerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label'         => 'Nom du Préstataire',
                'required'      => false
            ])
            ->add('email')
            ->add('telephone')
            ->add('city', TextType::class, [
                'label'         => 'Ville',
                'required'      => false
            ])
            ->add('contry', TextType::class, [
                'label'         => 'Pays de Residence',
                'required'      => false
            ])
            ->add('postal_code', TextType::class, [
                'label'         => 'Code Postal',
                'required'      => false
            ])
            ->add('address', TextType::class, [
                'label'         => 'Adresse',
                'required'      => false
            ])
            ->add('experience',)
            ->add('description', TextareaType::class)
            ->add('products', EntityType::class, [
                'label'           => false,
                'required'        => false,
                'class'           => Product::class,
                'choice_label'    => 'title',
                'multiple'        => true
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Seller::class,
        ]);
    }
}
