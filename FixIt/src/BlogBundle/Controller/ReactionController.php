<?php

namespace BlogBundle\Controller;

use BlogBundle\Entity\Reaction;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Reaction controller.
 *
 */
class ReactionController extends Controller
{
    /**
     * Lists all reaction entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $reactions = $em->getRepository('BlogBundle:Reaction')->findAll();

        return $this->render('reaction/index.html.twig', array(
            'reactions' => $reactions,
        ));
    }

    /**
     * Creates a new reaction entity.
     *
     */
    public function newAction(Request $request)
    {
        $reaction = new Reaction();
        $form = $this->createForm('BlogBundle\Form\ReactionType', $reaction);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->get('security.token_storage')->getToken()->getUser();
            $reaction->setUser($user);
            $em = $this->getDoctrine()->getManager();
            $em->persist($reaction);
            $em->flush();

            return $this->redirectToRoute('reaction_show', array('id' => $reaction->getId()));
        }

        return $this->render('reaction/new.html.twig', array(
            'reaction' => $reaction,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a reaction entity.
     *
     */
    public function showAction(Reaction $reaction)
    {
        $deleteForm = $this->createDeleteForm($reaction);

        return $this->render('reaction/show.html.twig', array(
            'reaction' => $reaction,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing reaction entity.
     *
     */
    public function editAction(Request $request, Reaction $reaction)
    {
        $deleteForm = $this->createDeleteForm($reaction);
        $editForm = $this->createForm('BlogBundle\Form\ReactionType', $reaction);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('reaction_edit', array('id' => $reaction->getId()));
        }

        return $this->render('reaction/edit.html.twig', array(
            'reaction' => $reaction,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a reaction entity.
     *
     */
    public function deleteAction(Request $request, Reaction $reaction)
    {
        $form = $this->createDeleteForm($reaction);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($reaction);
            $em->flush();
        }

        return $this->redirectToRoute('reaction_index');
    }

    /**
     * Creates a form to delete a reaction entity.
     *
     * @param Reaction $reaction The reaction entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Reaction $reaction)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('reaction_delete', array('id' => $reaction->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
