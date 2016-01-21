<?php

namespace Acme\StoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use PUGX\AutocompleterBundle\Form\Type\AutocompleteType;

class QuoteType extends AbstractType
{

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('text')
            //->add('author', EntityType::class, ['class' => 'AcmeStoreBundle:AuthorQuote', 'choice_label' => 'getName' ])
            ->add('author',AutocompleteType::class,['class' => 'AcmeStoreBundle:AuthorQuote', 'label' => 'Автор' ]);
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Acme\StoreBundle\Entity\Quote'
        ));
    }


}
