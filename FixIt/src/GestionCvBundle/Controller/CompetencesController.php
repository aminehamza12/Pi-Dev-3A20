<?php

namespace GestionCvBundle\Controller;

use GestionCvBundle\Entity\Competences;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Competence controller.
 *
 */
class CompetencesController extends Controller
{
    /**
     * Lists all competence entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $competences = $em->getRepository('GestionCvBundle:Competences')->findAll();

        return $this->render('competences/index.html.twig', array(
            'competences' => $competences,'user'=>null,
        ));
    }

    /**
     * Creates a new competence entity.
     *
     */
    public function newAction(Request $request)
    {
        $competence = new Competences();
        $form = $this->createForm('GestionCvBundle\Form\CompetencesType', $competence);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($competence);
            $em->flush();

            return $this->redirectToRoute('competences_show', array('id' => $competence->getId(),'user'=>null));
        }

        return $this->render('competences/new.html.twig', array(
            'competence' => $competence,
            'form' => $form->createView(),
            'user'=>null,
        ));
    }

    /**
     * Finds and displays a competence entity.
     *
     */
    public function showAction(Competences $competence)
    {
        $deleteForm = $this->createDeleteForm($competence);

        return $this->render('competences/show.html.twig', array(
            'competence' => $competence,
            'delete_form' => $deleteForm->createView(),
            'user'=>null,
        ));
    }

    /**
     * Displays a form to edit an existing competence entity.
     *
     */
    public function editAction(Request $request, Competences $competence)
    {
        $deleteForm = $this->createDeleteForm($competence);
        $editForm = $this->createForm('GestionCvBundle\Form\CompetencesType', $competence);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('competences_edit', array('id' => $competence->getId()));
        }

        return $this->render('competences/edit.html.twig', array(
            'competence' => $competence,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'user'=>null
        ));
    }

    /**
     * Deletes a competence entity.
     *
     */
    public function deleteAction(Request $request, Competences $competence)
    {
        $form = $this->createDeleteForm($competence);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($competence);
            $em->flush();
        }

        return $this->redirectToRoute('competences_index');
    }

    /**
     * Creates a form to delete a competence entity.
     *
     * @param Competences $competence The competence entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Competences $competence)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('competences_delete', array('id' => $competence->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
