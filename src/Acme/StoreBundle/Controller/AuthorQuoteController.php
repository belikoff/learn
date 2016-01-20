<?php

namespace Acme\StoreBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Acme\StoreBundle\Entity\AuthorQuote;
use Acme\StoreBundle\Form\AuthorQuoteType;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * AuthorQuote controller.
 *
 * @Route("/authorquote")
 */
class AuthorQuoteController extends Controller
{
    /**
     * Get a list of author for autocomplete.
     *
     * @Route("/authorquote_get_authors", name="authorquote_get_authors")
     */
    public function getAuthorQute(Request $request)
    {
        $term = $request->query->get('term', null);

        $em = $this->getDoctrine()->getManager();

        $authors = $em->getRepository('AcmeStoreBundle:AuthorQuote')->findByTerm($term);

        return new JsonResponse($authors);
    }
    /**
     * Lists all AuthorQuote entities.
     *
     * @Route("/", name="authorquote_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $authorQuotes = $em->getRepository('AcmeStoreBundle:AuthorQuote')->findAll();

        return $this->render('authorquote/index.html.twig', array(
            'authorQuotes' => $authorQuotes,
        ));
    }

    /**
     * Creates a new AuthorQuote entity.
     *
     * @Route("/new", name="authorquote_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $authorQuote = new AuthorQuote();
        $form = $this->createForm('Acme\StoreBundle\Form\AuthorQuoteType', $authorQuote);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($authorQuote);
            $em->flush();

            return $this->redirectToRoute('authorquote_show', array('id' => $authorQuote->getId()));
        }

        return $this->render('authorquote/new.html.twig', array(
            'authorQuote' => $authorQuote,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a AuthorQuote entity.
     *
     * @Route("/{id}", name="authorquote_show")
     * @Method("GET")
     */
    public function showAction(AuthorQuote $authorQuote)
    {
        $deleteForm = $this->createDeleteForm($authorQuote);

        return $this->render('authorquote/show.html.twig', array(
            'authorQuote' => $authorQuote,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing AuthorQuote entity.
     *
     * @Route("/{id}/edit", name="authorquote_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, AuthorQuote $authorQuote)
    {
        $deleteForm = $this->createDeleteForm($authorQuote);
        $editForm = $this->createForm('Acme\StoreBundle\Form\AuthorQuoteType', $authorQuote);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($authorQuote);
            $em->flush();

            return $this->redirectToRoute('authorquote_edit', array('id' => $authorQuote->getId()));
        }

        return $this->render('authorquote/edit.html.twig', array(
            'authorQuote' => $authorQuote,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a AuthorQuote entity.
     *
     * @Route("/{id}", name="authorquote_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, AuthorQuote $authorQuote)
    {
        $form = $this->createDeleteForm($authorQuote);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($authorQuote);
            $em->flush();
        }

        return $this->redirectToRoute('authorquote_index');
    }

    /**
     * Creates a form to delete a AuthorQuote entity.
     *
     * @param AuthorQuote $authorQuote The AuthorQuote entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(AuthorQuote $authorQuote)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('authorquote_delete', array('id' => $authorQuote->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

}
