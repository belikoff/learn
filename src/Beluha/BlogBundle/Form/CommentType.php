<?php

namespace Beluha\BlogBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

/**
 * Class CommentType
 */
class CommentType extends AbstractType
{
    /**
     * {@inheritDoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('authorName', null, ['label' => 'name'])
            ->add('body', null, ['label' => 'comment.singular'])
            ->add('send', SubmitType::class, ['label' => 'send'])
        ;
    }
    
    /**
     * {@inheritDoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Beluha\BlogBundle\Entity\Comment'
        ));
    }
    
}
