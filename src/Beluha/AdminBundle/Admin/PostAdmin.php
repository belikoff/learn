<?php

namespace Beluha\AdminBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use PUGX\AutocompleterBundle\Form\Type\AutocompleteType;
use Sonata\FormatterBundle\Form\Type\FormatterType;
use Sonata\FormatterBundle\Form\Type\SimpleFormatterType;

/**
 * Description of PostAdmin
 *
 * @author belikov
 */
class PostAdmin extends Admin
{

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('title')
            ->add('category', EntityType::class,
                [
                'class' => 'BeluhaBlogBundle:Category',
                'query_builder' => function($er) {
                    return $er->createQueryBuilder('c')
                        ->orderBy('c.root', 'ASC')
                        ->addOrderBy('c.lft', 'ASC');
                },
                'choice_label' => 'indentedTitle'
            ])
            ->add('body', null,
                [
                'attr' => [
                    'format' => 'richhtml',
                    'class' => 'ckeditor'
                ]
            ])
            /* ->add('body', 'sonata_simple_formatter_type', array(
              'format' => 'richhtml'
              )) */
            ->add('author', EntityType::class,
                ['class' => 'BeluhaSecurityBundle:User', 'choice_label' => 'getUsername'])
            ->add('keywords')
            ->add('description');
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('title');
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('title')
            ->add('author', null,
                [
                'associated_property' => 'username',
        ]);
    }
}