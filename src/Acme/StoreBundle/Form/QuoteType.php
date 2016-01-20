<?php

namespace Acme\StoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Acme\StoreBundle\Form\DataTransformer\EntityToNameTransformer;

class QuoteType extends AbstractType
{
    //private $om;
 
    /*public function __construct(ObjectManager $om)
    {
        $this->om = $om;
    }*/

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        //$class = $options['class'];
        //$transformer = new EntityToNameTransformer($this->om, $class);
        //$builder->addViewTransformer($transformer);
        $builder
            ->add('text')
            ->add('author', EntityType::class, ['class' => 'AcmeStoreBundle:AuthorQuote', 'choice_label' => 'getName' ])
            //->add('author', TextType::class);
        ;
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

   /* public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['update_route'] = $options['update_route'];
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setRequired(array('class', 'update_route'));
    }*/

    /*public function getParent()
    {
        return 'hidden';
    }*/

    /*public function getName()
    {
        return 'autocomplete_entity';
    }*/

}
