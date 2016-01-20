<?php

namespace Acme\StoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Acme\StoreBundle\Entity\Product;
use Acme\StoreBundle\Entity\Category;
use Acme\StoreBundle\Form\Type\ProductType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class DefaultController extends Controller {

    public function indexAction ( $_controller, Request $request ) {
        return $this->render ( 'AcmeStoreBundle:Default:index.html.twig', [
                    'controller' => $_controller,
                ] );
    }

    public function createAction ( Request $request, $_controller ) {
        /* $category = $this->getDoctrine()
          ->getRepository('AcmeStoreBundle:Category')
          ->find(1); */
        $product = new Product();
        //$product->setName('');
        //$product->setPrice('');
        //$product->setDescription(' ');
        //$product->setCount('');
        //$product->setCategory($category);

        $form = $this->createForm ( ProductType::class, $product, ['attr' => ['novalidate' => 'novalidate' ] ] );

        /* $form = $this->createFormBuilder ( $product, ['attr'=> ['novalidate' => 'novalidate']] )
          ->add ( 'name', TextType::class )
          ->add ( 'description', TextareaType::class )
          ->add ( 'price', NumberType::class )
          ->add ( 'count', NumberType::class )
          ->add ( 'category', EntityType::class, ['class' => 'AcmeStoreBundle:Category', 'choice_label' => 'getName' ] )
          ->add ( 'save', SubmitType::class, ['label' => 'Добавить продукт' ] )
          ->getForm (); */

        $form->handleRequest ( $request );

        if ( $form->isSubmitted () && $form->isValid () ) {

            //$em = $this->getDoctrine()->getEntityManager(); //Deprecate c 2.1 вместо него getManager
            $em = $this->getDoctrine ()->getManager ();
            //$em->persist($category);
            $em->persist ( $product );
            $em->flush ();
            $this->redirectToRoute ( 'acme_store_create' );
        }



        return $this->render ( 'AcmeStoreBundle:Default:create.html.twig', array(
                    'form'       => $form->createView (),
                    'controller' => $_controller,
                ) );
    }

    public function showAction ( $id, $_controller ) {
        /* $product = $this->getDoctrine()
          ->getRepository('AcmeStoreBundle:Product')
          ->find($id); */
        $em      = $this->getDoctrine ()->getManager ();
        $product = $em->getRepository ( 'AcmeStoreBundle:Product' )->find ( $id );

        if ( !$product ) {
            throw $this->createNotFoundException ( 'No product found for id ' . $id );
        }
        $category = $product->getCategory ();
        //echo get_class($category); exit;

        //return new Response ( 'Product count ' . $product->getCount () );
        return $this->render ( 'AcmeStoreBundle:Default:show.html.twig', array(
                    'product'       => $product,
                    'controller' => $_controller,
                ) );        
    }

    public function updateAction ( $id ) {
        $em      = $this->getDoctrine ()->getEntityManager ();
        $product = $em->getRepository ( 'AcmeStoreBundle:Product' )->find ( $id );

        if ( !$product ) {
            throw $this->createNotFoundException ( 'No product found for id ' . $id );
        }

        $product->setPrice ( rand ( 0, 500 ) );
        $em->flush ();

        return $this->redirect ( $this->generateUrl ( 'homepage' ) );
    }

}
