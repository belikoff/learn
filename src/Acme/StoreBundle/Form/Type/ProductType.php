<?php

namespace Acme\StoreBundle\Form\Type;

use Acme\StoreBundle\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\OptionsResolver\OptionsResolver;


class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add ( 'name', TextType::class )
            ->add ( 'description', TextareaType::class )
            ->add ( 'price', NumberType::class )
            ->add ( 'count', NumberType::class )
            ->add ( 'category', EntityType::class, ['class' => 'AcmeStoreBundle:Category', 'choice_label' => 'getName' ] )
            ->add ( 'save', SubmitType::class, ['label' => 'Добавить продукт' ] );
    }

    public function getName()
    {
        return 'product';
    }
    /* Выкидывает предупреждение с одним аргументом, надо разобраться
     * public function configureOptions ( OptionsResolver $resolver ) {
        $resolver->setDefault([
            'data_class' => 'AcmeStoreBundle\Enetyti\Product',
        ]);
    }*/
}