<?php

namespace BlogBundle\Controller;

use BlogBundle\Entity\NewsLetterListUser;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Newsletterlistuser controller.
 *
 */
class NewsLetterListUserController extends Controller
{
    /**
     * Lists all newsLetterListUser entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $newsLetterListUsers = $em->getRepository('BlogBundle:NewsLetterListUser')->findAll();

        return $this->render('newsletterlistuser/index.html.twig', array(
            'newsLetterListUsers' => $newsLetterListUsers,
        ));
    }

    /**
     * Creates a new newsLetterListUser entity.
     *
     */
    public function newAction(Request $request)
    {
        $newsLetterListUser = new Newsletterlistuser();
        $form = $this->createForm('BlogBundle\Form\NewsLetterListUserType', $newsLetterListUser);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->get('security.token_storage')->getToken()->getUser();
            $newsLetterListUser->setUser($user);
            $em = $this->getDoctrine()->getManager();
            $em->persist($newsLetterListUser);
            $em->flush();

            return $this->redirectToRoute('newsletterlistuser_show', array('id' => $newsLetterListUser->getId()));
        }

        return $this->render('newsletterlistuser/new.html.twig', array(
            'newsLetterListUser' => $newsLetterListUser,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a newsLetterListUser entity.
     *
     */
    public function showAction(NewsLetterListUser $newsLetterListUser)
    {
        $deleteForm = $this->createDeleteForm($newsLetterListUser);

        return $this->render('newsletterlistuser/show.html.twig', array(
            'newsLetterListUser' => $newsLetterListUser,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing newsLetterListUser entity.
     *
     */
    public function editAction(Request $request, NewsLetterListUser $newsLetterListUser)
    {
        $deleteForm = $this->createDeleteForm($newsLetterListUser);
        $editForm = $this->createForm('BlogBundle\Form\NewsLetterListUserType', $newsLetterListUser);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('newsletterlistuser_edit', array('id' => $newsLetterListUser->getId()));
        }

        return $this->render('newsletterlistuser/edit.html.twig', array(
            'newsLetterListUser' => $newsLetterListUser,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a newsLetterListUser entity.
     *
     */
    public function deleteAction(Request $request, NewsLetterListUser $newsLetterListUser)
    {
        $form = $this->createDeleteForm($newsLetterListUser);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($newsLetterListUser);
            $em->flush();
        }

        return $this->redirectToRoute('newsletterlistuser_index');
    }

    /**
     * Creates a form to delete a newsLetterListUser entity.
     *
     * @param NewsLetterListUser $newsLetterListUser The newsLetterListUser entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(NewsLetterListUser $newsLetterListUser)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('newsletterlistuser_delete', array('id' => $newsLetterListUser->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
