<?php

namespace BlogBundle\Controller;

use BlogBundle\Entity\NewsLetterTemplate;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Newslettertemplate controller.
 *
 */
class NewsLetterTemplateController extends Controller
{
    /**
     * Lists all newsLetterTemplate entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $newsLetterTemplates = $em->getRepository('BlogBundle:NewsLetterTemplate')->findAll();

        return $this->render('newslettertemplate/index.html.twig', array(
            'newsLetterTemplates' => $newsLetterTemplates,
        ));
    }

    /**
     * Creates a new newsLetterTemplate entity.
     *
     */
    public function newAction(Request $request)
    {
        $newsLetterTemplate = new Newslettertemplate();
        $form = $this->createForm('BlogBundle\Form\NewsLetterTemplateType', $newsLetterTemplate);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->get('security.token_storage')->getToken()->getUser();
            $newsLetterTemplate->setUser($user);
            $em = $this->getDoctrine()->getManager();
            $em->persist($newsLetterTemplate);
            $em->flush();

            return $this->redirectToRoute('newslettertemplate_show', array('id' => $newsLetterTemplate->getId()));
        }

        return $this->render('newslettertemplate/new.html.twig', array(
            'newsLetterTemplate' => $newsLetterTemplate,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a newsLetterTemplate entity.
     *
     */
    public function showAction(NewsLetterTemplate $newsLetterTemplate)
    {
        $deleteForm = $this->createDeleteForm($newsLetterTemplate);

        return $this->render('newslettertemplate/show.html.twig', array(
            'newsLetterTemplate' => $newsLetterTemplate,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing newsLetterTemplate entity.
     *
     */
    public function editAction(Request $request, NewsLetterTemplate $newsLetterTemplate)
    {
        $deleteForm = $this->createDeleteForm($newsLetterTemplate);
        $editForm = $this->createForm('BlogBundle\Form\NewsLetterTemplateType', $newsLetterTemplate);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('newslettertemplate_edit', array('id' => $newsLetterTemplate->getId()));
        }

        return $this->render('newslettertemplate/edit.html.twig', array(
            'newsLetterTemplate' => $newsLetterTemplate,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a newsLetterTemplate entity.
     *
     */
    public function deleteAction(Request $request, NewsLetterTemplate $newsLetterTemplate)
    {
        $form = $this->createDeleteForm($newsLetterTemplate);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($newsLetterTemplate);
            $em->flush();
        }

        return $this->redirectToRoute('newslettertemplate_index');
    }

    /**
     * Creates a form to delete a newsLetterTemplate entity.
     *
     * @param NewsLetterTemplate $newsLetterTemplate The newsLetterTemplate entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(NewsLetterTemplate $newsLetterTemplate)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('newslettertemplate_delete', array('id' => $newsLetterTemplate->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
