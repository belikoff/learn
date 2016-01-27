<?php

namespace Beluha\AdminBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use PUGX\AutocompleterBundle\Form\Type\AutocompleteType;

/**
 * Description of QuoteAdmin
 *
 * @author belikov
 */
class QuoteAdmin extends Admin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('text')
            //->add('author', AutocompleteType::class, ['class' => 'BeluhaBlogBundle:AuthorQuote', 'label' => 'Автор']);
            ->add('author', EntityType::class, ['class' => 'BeluhaBlogBundle:AuthorQuote', 'choice_label' => 'getName' ]);
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('text');
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('text')
            ->add('author', null, [
                'associated_property' => 'name',
                'editable' => true
                ]);
    }
}
