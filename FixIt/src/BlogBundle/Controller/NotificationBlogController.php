<?php

namespace BlogBundle\Controller;

use BlogBundle\Entity\NotificationBlog;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Notificationblog controller.
 *
 */
class NotificationBlogController extends Controller
{
    /**
     * Lists all notificationBlog entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $notificationBlogs = $em->getRepository('BlogBundle:NotificationBlog')->findAll();

        return $this->render('notificationblog/index.html.twig', array(
            'notificationBlogs' => $notificationBlogs,
        ));
    }

    /**
     * Creates a new notificationBlog entity.
     *
     */
    public function newAction(Request $request)
    {
        $notificationBlog = new Notificationblog();
        $form = $this->createForm('BlogBundle\Form\NotificationBlogType', $notificationBlog);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user= $this->get('security.token_storage')->getToken()->getUser(); // get the current user
            $em = $this->getDoctrine()->getManager();
            $notificationBlog->setUser($user);
            $em->persist($notificationBlog);
            $em->flush();

            return $this->redirectToRoute('notificationblog_show', array('id' => $notificationBlog->getId()));
        }

        return $this->render('notificationblog/new.html.twig', array(
            'notificationBlog' => $notificationBlog,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a notificationBlog entity.
     *
     */
    public function showAction(NotificationBlog $notificationBlog)
    {
        $deleteForm = $this->createDeleteForm($notificationBlog);

        return $this->render('notificationblog/show.html.twig', array(
            'notificationBlog' => $notificationBlog,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing notificationBlog entity.
     *
     */
    public function editAction(Request $request, NotificationBlog $notificationBlog)
    {
        $deleteForm = $this->createDeleteForm($notificationBlog);
        $editForm = $this->createForm('BlogBundle\Form\NotificationBlogType', $notificationBlog);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('notificationblog_edit', array('id' => $notificationBlog->getId()));
        }

        return $this->render('notificationblog/edit.html.twig', array(
            'notificationBlog' => $notificationBlog,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a notificationBlog entity.
     *
     */
    public function deleteAction(Request $request, NotificationBlog $notificationBlog)
    {
        $form = $this->createDeleteForm($notificationBlog);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($notificationBlog);
            $em->flush();
        }

        return $this->redirectToRoute('notificationblog_index');
    }

    /**
     * Creates a form to delete a notificationBlog entity.
     *
     * @param NotificationBlog $notificationBlog The notificationBlog entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(NotificationBlog $notificationBlog)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('notificationblog_delete', array('id' => $notificationBlog->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
