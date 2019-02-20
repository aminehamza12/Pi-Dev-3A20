<?php

namespace BlogBundle\Controller;

use BlogBundle\Entity\BlogViews;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Blogview controller.
 *
 */
class BlogViewsController extends Controller
{
    /**
     * Lists all blogView entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $blogViews = $em->getRepository('BlogBundle:BlogViews')->findAll();

        return $this->render('blogviews/index.html.twig', array(
            'blogViews' => $blogViews,
        ));
    }

    /**
     * Creates a new blogView entity.
     *
     */
    public function newAction(Request $request)
    {
        $blogView = new Blogviews();
        $form = $this->createForm('BlogBundle\Form\BlogViewsType', $blogView);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($blogView);
            $em->flush();

            return $this->redirectToRoute('blogviews_show', array('id' => $blogView->getId()));
        }

        return $this->render('blogviews/new.html.twig', array(
            'blogView' => $blogView,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a blogView entity.
     *
     */
    public function showAction(BlogViews $blogView)
    {
        $deleteForm = $this->createDeleteForm($blogView);

        return $this->render('blogviews/show.html.twig', array(
            'blogView' => $blogView,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing blogView entity.
     *
     */
    public function editAction(Request $request, BlogViews $blogView)
    {
        $deleteForm = $this->createDeleteForm($blogView);
        $editForm = $this->createForm('BlogBundle\Form\BlogViewsType', $blogView);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('blogviews_edit', array('id' => $blogView->getId()));
        }

        return $this->render('blogviews/edit.html.twig', array(
            'blogView' => $blogView,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a blogView entity.
     *
     */
    public function deleteAction(Request $request, BlogViews $blogView)
    {
        $form = $this->createDeleteForm($blogView);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($blogView);
            $em->flush();
        }

        return $this->redirectToRoute('blogviews_index');
    }

    /**
     * Creates a form to delete a blogView entity.
     *
     * @param BlogViews $blogView The blogView entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(BlogViews $blogView)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('blogviews_delete', array('id' => $blogView->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
