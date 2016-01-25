<?php

namespace Beluha\BlogBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Beluha\BlogBundle\Entity\Quote;
use Beluha\BlogBundle\Form\QuoteType;
use Symfony\Component\VarDumper\VarDumper;
use Symfony\Component\HttpFoundation\Response;


/**
 * Quote controller.
 *
 * @Route("/authorquote/quote")
 */
class QuoteController extends Controller
{
    /**
     * List quote.
     *
     * @Route("/", name="authorquote_quote_index")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $dumer = new VarDumper();
        //$quotes = $em->getRepository('BeluhaBlogBundle:Quote')->findAll();

        $dql   = "SELECT q, a FROM BeluhaBlogBundle:Quote q JOIN q.author a";
        $query = $em->createQuery($dql);
        $paginator  = $this->get('knp_paginator');

        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            5/*limit per page*/
        );
        $dumer->dump($pagination);
        //return $this->render('quote/index.html.twig', array(
           // 'quotes' => $quotes,
        //));
        return $this->render('quote/index.html.twig', array(
            'pagination' => $pagination,
        ));
    }
    /**
     * Random quote.
     *
     * @Route("/random-quote", name="authorquote_quote_random")
     * @Method("POST")
     */
    public function getRamdomQuoteAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $id = null;
        if($request->isXmlHttpRequest()){
            $id = $request->request->get('id');
        }
        $quote = $em->getRepository('BeluhaBlogBundle:Quote')->getRandom($id);
        //$dumper = new VarDumper();
        //$dumper->dump($quote);
        return $this->render('BeluhaBlogBundle::quoteBlock.html.twig',['quote' => $quote]);
    }

    /**
     * Creates a new Quote entity.
     *
     * @Route("/new", name="authorquote_quote_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $quote = new Quote();
        $form = $this->createForm('Beluha\BlogBundle\Form\QuoteType', $quote);
        $form->handleRequest($request);
        $user = $this->getUser();
        $quote->setByAdded($user);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($quote);
            $em->flush();

            return $this->redirectToRoute('authorquote_quote_show', array('id' => $quote->getId()));
        }

        return $this->render('quote/new.html.twig', array(
            'quote' => $quote,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Quote entity.
     *
     * @Route("/{id}", name="authorquote_quote_show")
     * @Method("GET")
     */
    public function showAction(Quote $quote)
    {
        $deleteForm = $this->createDeleteForm($quote);

        return $this->render('quote/show.html.twig', array(
            'quote' => $quote,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Quote entity.
     *
     * @Route("/{id}/edit", name="authorquote_quote_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Quote $quote)
    {
        $deleteForm = $this->createDeleteForm($quote);
        $editForm = $this->createForm('Beluha\BlogBundle\Form\QuoteType', $quote);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($quote);
            $em->flush();

            return $this->redirectToRoute('authorquote_quote_edit', array('id' => $quote->getId()));
        }

        return $this->render('quote/edit.html.twig', array(
            'quote' => $quote,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Quote entity.
     *
     * @Route("/{id}", name="authorquote_quote_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Quote $quote)
    {
        $form = $this->createDeleteForm($quote);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($quote);
            $em->flush();
        }

        return $this->redirectToRoute('authorquote_quote_index');
    }

    /**
     * Creates a form to delete a Quote entity.
     *
     * @param Quote $quote The Quote entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Quote $quote)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('authorquote_quote_delete', array('id' => $quote->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
    

}
