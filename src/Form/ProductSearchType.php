<?php

namespace App\Form;

use App\SearchEntity\ProductSearch;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('title', TextType::class, [
            'label'             => false,
            'attr'  => [
                'placeholder'   => 'Ex: Chemise'
            ],
            'required'          => false,
        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class'        => ProductSearch::class,
            // 'method'             => 'get',
            // ' csrf_protection'    => false
        ]);
    }
    /**
     * ceci retour le prefixe. Mais nous nous conterons dans ce cas d'en reduire en vue d'avoir
     * url propre vue qu'on est en get. Sinon on aura une url qui ressemblera a ceci:
     * url/?property_search%5BmaxPrice%5D=4&property_search%5BminSurface%5D=4&
     * property_search%5B_token%5D=NRLMYzkjYCAJbkjKXsdbFp2a-GiUVRWtA6sjtKsvtAA
     */

    public function getBlockPrefix()
    {
        return false;
    }
}
