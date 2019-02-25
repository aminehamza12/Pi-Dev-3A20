<?php

namespace FixitBundle\Controller;

use FixitBundle\Entity\Media;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use FixitBundle\Entity\product;
/**
 * Media controller.
 *
 */
class MediaController extends Controller
{
    /**
     * Lists all Media entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $media = $em->getRepository('FixitBundle:Media')->findAll();

        return $this->render('media/index.html.twig', array(
            'media' => $media,
        ));
    }

    /**
     * Creates a new Media entity.
     *
     */

    public function newAction(Request $request,product $product)
    {
        $em = $this->getDoctrine()->getManager();
        $Media = new Media();
        $form = $this->createForm('FixitBundle\Form\MediaType', $Media);
        $form->handleRequest($request);
        $product = $em->getRepository('FixitBundle:product')->find($product);
        $Media->setProductId($product);
        $user=$this->getUser();
        $Media->setUserId($user);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $file = $Media->getBrochure();

            $fileName = md5(uniqid()) . '.' . $file->guessExtension();
            $file->move($this->getParameter('Brochure_dir'), $fileName);
            $Media->setBrochure('http://localhost/fixit1/web/images/' . $fileName);
            $em->persist($Media);
            $em->flush();

            return $this->redirectToRoute('product_index', array('id' => $Media->getId()));
        }

        return $this->render('media/new.html.twig', array(
            'Media' => $Media,
            'form' => $form->createView(),'user'=> $user
        ));
    }

    /**
     * Finds and displays a Media entity.
     *
     */
    public function showAction(Media $Media)
    {
        $deleteForm = $this->createDeleteForm($Media);

        return $this->render('media/show.html.twig', array(
            'Media' => $Media,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Media entity.
     *
     */
    public function editAction(Request $request, Media $Media)
    {
        $deleteForm = $this->createDeleteForm($Media);
        $editForm = $this->createForm('FixitBundle\Form\MediaType', $Media);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('media_edit', array('id' => $Media->getId()));
        }

        return $this->render('media/edit.html.twig', array(
            'Media' => $Media,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Media entity.
     *
     */
    public function deleteAction(Request $request, Media $Media)
    {
        $form = $this->createDeleteForm($Media);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($Media);
            $em->flush();
        }

        return $this->redirectToRoute('media_index');
    }

    /**
     * Creates a form to delete a Media entity.
     *
     * @param Media $Media The Media entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Media $Media)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('media_delete', array('id' => $Media->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
