<?php

namespace ForumBundle\Controller;

use ForumBundle\Form\ReclamtionType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use ForumBundle\Entity\Reclamation;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;
use ForumBundle\Entity\UserForum;


/**
 * Reclamation controller.
 *
 * @Route("Forum")
 */
class ReclamationController extends Controller
{
    public function newAction(Request $request)
    {
        $us = $this->getUser();
        $em=$this->getDoctrine()->getManager();
        $reclamation = new Reclamation();
        $form = $this->createForm(ReclamtionType::class, $reclamation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

                $reclamation->setUser($us);
            $reclamation->setDate(new \DateTime('now'));
            $reclamation->setEtat('attente');

            $em->persist($reclamation);
            $em->flush();
            return $this->redirectToRoute('consulter_reclamation');
        }

        return $this->render('Reclamtion/new.html.twig', array(
            'reclamation' => $reclamation,
            'form' => $form->createView(),
        ));
    }

    public function afficherAction(){

        $em=$this->getDoctrine()->getManager();
        $reclamation = $em->getRepository(Reclamation::class)->findOneByUser($this->getUser());
        $c=$this->getUser()->getReclamations()->count();
        dump($c);

        return $this->render('Reclamtion/reclamation.html.twig', array(
            'reclamation' => $reclamation));

    }
}
