<?php

namespace Beluha\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use Symfony\Component\HttpFoundation\Request;

use Beluha\BlogBundle\Entity\Author;
use Beluha\BlogBundle\Form\AuthorType;

/**
 * Class AuthorController
 */
class AuthorController extends Controller
{
    /**
     * Show post by author
     * 
     * @param string $slug
     * 
     * @throws NotFoundHttpException
     * @return array
     * 
     * @Template()
     */
    public function showAction($slug)
    {
        $author = $this->getDoctrine()->getRepository('BeluhaSecurityBundle:User')->findOneBy(
                [
                    'slug' => $slug,
                ]);
        if(null === $author){
            throw $this->createNotFoundException('Такой автор не найден');
        }
        
        $posts = $this->getDoctrine()->getRepository('BeluhaBlogBundle:Post')->findBy(
                [
                    'author' => $author
                ]);
        
        return [
            'author' => $author,
            'posts' =>  $posts
                ];
    }
    /**
     * Lists all Author entities.
     *
     * @return array
     *
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('BeluhaBlogBundle:Author')->findAll();
        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Author entity.
     *
     * @param Request $request
     *
     * @return array
     *
     * @Method("POST")
     * @Template("AdminBundle:Author:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Author();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            return $this->redirect($this->generateUrl('core_author_showadmin', array('id' => $entity->getId())));
        }
        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }
    /**
     * Creates a form to create a Author entity.
     *
     * @param Author $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Author $entity)
    {
        $form = $this->createForm(AuthorType::class, $entity, array(
            'action' => $this->generateUrl('core_author_create'),
            'method' => 'POST',
        ));
        $form->add('submit', SubmitType::class, array('label' => 'Create'));
        return $form;
    }
    /**
     * Displays a form to create a new Author entity.
     *
     * @return array
     *
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Author();
        $form = $this->createCreateForm($entity);
        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }
    /**
     * Finds and displays a Author entity.
     *
     * @param int $id
     *
     * @throws NotFoundHttpException
     * @return array
     * 
     * @Method("GET")
     * @Template("Beluha\BlogBundle:Author:admin_show.html.twig")
     */
    public function showAdminAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('BeluhaBlogBundle:Author')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Author entity.');
        }
        $deleteForm = $this->createDeleteForm($id);
        return array(
            'entity' => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Displays a form to edit an existing Author entity.
     *
     * @param int $id
     *
     * @throws NotFoundHttpException
     * @return array
     *
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        /** @var Author $entity */
        $entity = $em->getRepository('BeluhaBlogBundle:Author')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Author entity.');
        }
        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);
        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Creates a form to edit a Author entity.
     *
     * @param Author $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Author $entity)
    {
        $form = $this->createForm(new AuthorType(), $entity, array(
            'action' => $this->generateUrl('core_author_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));
        $form->add('submit', SubmitType::class, array('label' => 'Update'));
        return $form;
    }
    /**
     * Edits an existing Author entity.
     *
     * @param Request $request
     * @param int     $id
     *
     * @throws NotFoundHttpException
     * @return array
     *
     * @Template("AdminBundle:Author:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        /** @var Author $entity */
        $entity = $em->getRepository('BeluhaBlogBundle:Author')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Author entity.');
        }
        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);
        if ($editForm->isValid()) {
            $em->flush();
            return $this->redirect($this->generateUrl('core_author_edit', array('id' => $id)));
        }
        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Author entity.
     *
     * @param Request $request
     * @param int     $id
     *
     * @throws NotFoundHttpException
     * @return array
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('BeluhaBlogBundle:Author')->find($id);
            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Author entity.');
            }
            $em->remove($entity);
            $em->flush();
        }
        return $this->redirect($this->generateUrl('core_author_index'));
    }
    /**
     * Creates a form to delete a Author entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('core_author_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', SubmitType::class, array('label' => 'Delete'))
            ->getForm();
    }
}
