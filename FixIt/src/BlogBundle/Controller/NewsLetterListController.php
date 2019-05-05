<?php

namespace BlogBundle\Controller;

use BlogBundle\Entity\NewsLetterList;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Newsletterlist controller.
 *
 */
class NewsLetterListController extends Controller
{
    /**
     * Lists all newsLetterList entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $newsLetterLists = $em->getRepository('BlogBundle:NewsLetterList')->findAll();

        return $this->render('newsletterlist/index.html.twig', array(
            'newsLetterLists' => $newsLetterLists,
        ));
    }

    /**
     * Creates a new newsLetterList entity.
     *
     */
    public function newAction(Request $request)
    {
        $newsLetterList = new Newsletterlist();
        $form = $this->createForm('BlogBundle\Form\NewsLetterListType', $newsLetterList);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($newsLetterList);
            $em->flush();

            return $this->redirectToRoute('newsletterlist_show', array('id' => $newsLetterList->getId()));
        }

        return $this->render('newsletterlist/new.html.twig', array(
            'newsLetterList' => $newsLetterList,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a newsLetterList entity.
     *
     */
    public function showAction(NewsLetterList $newsLetterList)
    {
        $deleteForm = $this->createDeleteForm($newsLetterList);

        return $this->render('newsletterlist/show.html.twig', array(
            'newsLetterList' => $newsLetterList,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing newsLetterList entity.
     *
     */
    public function editAction(Request $request, NewsLetterList $newsLetterList)
    {
        $deleteForm = $this->createDeleteForm($newsLetterList);
        $editForm = $this->createForm('BlogBundle\Form\NewsLetterListType', $newsLetterList);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('newsletterlist_edit', array('id' => $newsLetterList->getId()));
        }

        return $this->render('newsletterlist/edit.html.twig', array(
            'newsLetterList' => $newsLetterList,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a newsLetterList entity.
     *
     */
    public function deleteAction(Request $request, NewsLetterList $newsLetterList)
    {
        $form = $this->createDeleteForm($newsLetterList);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($newsLetterList);
            $em->flush();
        }

        return $this->redirectToRoute('newsletterlist_index');
    }

    /**
     * Creates a form to delete a newsLetterList entity.
     *
     * @param NewsLetterList $newsLetterList The newsLetterList entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(NewsLetterList $newsLetterList)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('newsletterlist_delete', array('id' => $newsLetterList->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
