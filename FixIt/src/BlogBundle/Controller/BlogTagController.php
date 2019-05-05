<?php

namespace BlogBundle\Controller;

use BlogBundle\Entity\BlogTag;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Blogtag controller.
 *
 */
class BlogTagController extends Controller
{
    /**
     * Lists all blogTag entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $blogTags = $em->getRepository('BlogBundle:BlogTag')->findAll();

        return $this->render('blogtag/index.html.twig', array(
            'blogTags' => $blogTags,
        ));
    }

    /**
     * Creates a new blogTag entity.
     *
     */
    public function newAction(Request $request)
    {
        $blogTag = new Blogtag();
        $form = $this->createForm('BlogBundle\Form\BlogTagType', $blogTag);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($blogTag);
            $em->flush();

            return $this->redirectToRoute('blogtag_show', array('id' => $blogTag->getId()));
        }

        return $this->render('blogtag/new.html.twig', array(
            'blogTag' => $blogTag,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a blogTag entity.
     *
     */
    public function showAction(BlogTag $blogTag)
    {
        $deleteForm = $this->createDeleteForm($blogTag);

        return $this->render('blogtag/show.html.twig', array(
            'blogTag' => $blogTag,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing blogTag entity.
     *
     */
    public function editAction(Request $request, BlogTag $blogTag)
    {
        $deleteForm = $this->createDeleteForm($blogTag);
        $editForm = $this->createForm('BlogBundle\Form\BlogTagType', $blogTag);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('blogtag_edit', array('id' => $blogTag->getId()));
        }

        return $this->render('blogtag/edit.html.twig', array(
            'blogTag' => $blogTag,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a blogTag entity.
     *
     */
    public function deleteAction(Request $request, BlogTag $blogTag)
    {
        $form = $this->createDeleteForm($blogTag);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($blogTag);
            $em->flush();
        }

        return $this->redirectToRoute('blogtag_index');
    }

    /**
     * Creates a form to delete a blogTag entity.
     *
     * @param BlogTag $blogTag The blogTag entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(BlogTag $blogTag)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('blogtag_delete', array('id' => $blogTag->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
