<?php

namespace FixitBundle\Controller;

use FixitBundle\Entity\ifixit;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use FixitBundle\Entity\Videos;

/**
 * ifixit controller.
 *
 */
class ifixitController extends Controller
{
    /**
     * Lists all ifixit entities.
     *
     */
    public function indexAction(Request $request)
    {


        $em    = $this->get('doctrine.orm.entity_manager');
        $dql   = "SELECT a FROM FixitBundle:ifixit a";
        $query = $em->createQuery($dql);

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            2/*limit per page*/
        );


        return $this->render('@Fixit/ifixit/index.html.twig', array(
            'ifixits' => $pagination,
        ));
    }
    public function indexAdminAction()
    {

        $em = $this->getDoctrine()->getManager();

        $ifixits = $em->getRepository('FixitBundle:ifixit')->findAll();
        $videos=$this->getDoctrine()->getRepository(Videos::class)->findAll();

        return $this->render('@Fixit/ifixit/indexAdmin.html.twig', array(
            'ifixits' => $ifixits,
            'videos'=> $videos,
        ));
    }

    /**
     * Creates a new ifixit entity.
     *
     */
    public function newAction(Request $request)
    {
        $ifixit = new ifixit();
        $form = $this->createForm('FixitBundle\Form\ifixitType', $ifixit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $ifixit->setNbr(0);
            $em->persist($ifixit);
            $em->flush();

            return $this->redirectToRoute('ifixit_indexAdmin', array('id' => $ifixit->getId()));
        }

        return $this->render('@Fixit/ifixit/new.html.twig', array(
            'ifixit' => $ifixit,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a ifixit entity.
     *
     */
    public function showAction(ifixit $ifixit,Request $request)
    {
        $videos=$this->getDoctrine()->getRepository(Videos::class)->findBy(array(
            'ifixit'=>$ifixit,
        ));

        $fvideo=reset($videos);
        return $this->render('@Fixit/ifixit/show.html.twig', array(
            'ifixit' => $ifixit,
            'fvideo'=>$fvideo,
            'videos'=>$videos,
        ));
    }

    /**
     * Displays a form to edit an existing ifixit entity.
     *
     */
    public function editAction(Request $request, ifixit $ifixit)
    {
        $deleteForm = $this->createDeleteForm($ifixit);
        $editForm = $this->createForm('FixitBundle\Form\ifixitType', $ifixit);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('ifixit_indexAdmin');
        }

        return $this->render('@Fixit/ifixit/edit.html.twig', array(
            'ifixit' => $ifixit,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a ifixit entity.
     *
     */
    public function deleteAction(Request $request, ifixit $ifixit)
    {
        $form = $this->createDeleteForm($ifixit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($ifixit);
            $em->flush();
        }

        return $this->redirectToRoute('ifixit_indexAdmin');
    }

    /**
     * Creates a form to delete a ifixit entity.
     *
     * @param ifixit $ifixit The ifixit entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(ifixit $ifixit)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('ifixit_delete', array('id' => $ifixit->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    public function addVideoAction($id,Request $request)
    {
        $video = new Videos();
        $form = $this->createForm('FixitBundle\Form\VideosType', $video);
        $form->handleRequest($request);
        $ifxit=$this->getDoctrine()->getRepository(ifixit::class)->find($id);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $video->setIfixit($ifxit);
            $em->persist($video);
            $ifxit->setNbr($ifxit->getNbr()+1);
            $em->flush();

            return $this->redirectToRoute('ifixit_indexAdmin');
        }

        return $this->render('@Fixit/videos/new.html.twig', array(
            'video' => $video,
            'form' => $form->createView(),
            'ifixit'=>$ifxit,
        ));
    }

    public function deleteVideoAction($id)
    {
        $em=$this->getDoctrine()->getManager();
        $video=$this->getDoctrine()->getRepository(Videos::class)->find($id);
        $ifixit=$this->getDoctrine()->getRepository(ifixit::class)->find($video->getIfixit());
        $ifixit->setNbr($ifixit->getNbr()-1);
        $em->remove($video);
        $em->flush();
        $response= new JsonResponse();
        $data=array('reponse'=>'success');
        $response->setData($data,200);
        return $response;
    }

    public function deleteifixitAction($id)
    {
        $em=$this->getDoctrine()->getManager();
        $ifixit=$this->getDoctrine()->getRepository(ifixit::class)->find($id);
        $em->remove($ifixit);
        $em->flush();
        $response= new JsonResponse();
        $data=array('reponse'=>'success');
        $response->setData($data,200);
        return $response;
    }

}
