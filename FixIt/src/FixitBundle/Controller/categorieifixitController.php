<?php

namespace FixitBundle\Controller;

use FixitBundle\Entity\categorieifixit;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Categorieifixit controller.
 *
 */
class categorieifixitController extends Controller
{
    /**
     * Lists all categorieifixit entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $categorieifixits = $em->getRepository('FixitBundle:categorieifixit')->findAll();

        return $this->render('@Fixit/categorieifixit/index.html.twig', array(
            'categorieifixits' => $categorieifixits,
        ));
    }

    /**
     * Creates a new categorieifixit entity.
     *
     */
    public function newAction(Request $request)
    {
        $categorieifixit = new Categorieifixit();
        $form = $this->createForm('FixitBundle\Form\categorieifixitType', $categorieifixit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($categorieifixit);
            $em->flush();

            return $this->redirectToRoute('categorieifixit_show', array('id' => $categorieifixit->getId()));
        }

        return $this->render('@Fixit/categorieifixit/new.html.twig', array(
            'categorieifixit' => $categorieifixit,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a categorieifixit entity.
     *
     */
    public function showAction(categorieifixit $categorieifixit)
    {
        $deleteForm = $this->createDeleteForm($categorieifixit);

        return $this->render('@Fixit/categorieifixit/show.html.twig', array(
            'categorieifixit' => $categorieifixit,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing categorieifixit entity.
     *
     */
    public function editAction(Request $request, categorieifixit $categorieifixit)
    {
        $deleteForm = $this->createDeleteForm($categorieifixit);
        $editForm = $this->createForm('FixitBundle\Form\categorieifixitType', $categorieifixit);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('categorieifixit_indexAdmin', array('id' => $categorieifixit->getId()));
        }

        return $this->render('@Fixit/categorieifixit/edit.html.twig', array(
            'categorieifixit' => $categorieifixit,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a categorieifixit entity.
     *
     */
    public function deleteAction(Request $request, categorieifixit $categorieifixit)
    {
        $form = $this->createDeleteForm($categorieifixit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($categorieifixit);
            $em->flush();
        }

        return $this->redirectToRoute('categorieifixit_index');
    }

    /**
     * Creates a form to delete a categorieifixit entity.
     *
     * @param categorieifixit $categorieifixit The categorieifixit entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(categorieifixit $categorieifixit)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('categorieifixit_delete', array('id' => $categorieifixit->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
