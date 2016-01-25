<?php

namespace Beluha\BlogBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use PUGX\AutocompleterBundle\Form\Type\AutocompleteType;
use Gregwar\CaptchaBundle\Type\CaptchaType;

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
            //->add('author', EntityType::class, ['class' => 'BeluhaBlogBundle:AuthorQuote', 'choice_label' => 'getName' ])
            ->add('author', AutocompleteType::class, ['class' => 'BeluhaBlogBundle:AuthorQuote', 'label' => 'Автор'])
            ->add('captcha', CaptchaType::class, [
                'width' => 200,
                'height' => 50,
                'length' => 6,
                'as_url' => TRUE,
                'reload' => TRUE,
                'background_color' => [243,243,243],
        ]);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Beluha\BlogBundle\Entity\Quote'
        ));
    }
}
