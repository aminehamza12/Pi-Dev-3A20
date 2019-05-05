<?php

namespace ForumBundle\Controller;

use ForumBundle\Form\TopicType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use ForumBundle\Entity\Commentaire;
use ForumBundle\Entity\Reclamation;
use ForumBundle\Entity\Topic;
class AdminController extends Controller
{
    public function topicsAction(){

        $em = $this->getDoctrine()->getManager();
        $topics = $em->getRepository(Topic::class)->findAll();
        return $this->render('Admin/topics.html.twig', array(
            "topics" => $topics,

        ));



    }

    public function reclamationsAction(){

        $em = $this->getDoctrine()->getManager();
        $reclamations = $em->getRepository(Reclamation::class)->findAll();
        return $this->render('Admin/reclamations.html.twig', array(
            "reclamations" => $reclamations

        ));



    }

    public function commentRepAction()
    {

        $em = $this->getDoctrine()->getManager();
        $commentaires = $em->getRepository(Commentaire::class)->findBy(array("etatCommentaire" => "reported"));
        return $this->render('Admin/commentsRep.html.twig', array(
            "commentaires" => $commentaires,

        ));
    }

    public function upTopicAction(Request $request){

        $id = $request->get("id");
        $em = $this->getDoctrine()->getManager();
        $topic = $this->getDoctrine()->getRepository(Topic::class)->find($id);
        $form = $this->createForm(TopicType::class, $topic);
        $form->handleRequest($request);
        if ($form->isValid() && $form->isSubmitted()) {
            $topic->upload();
            $em->persist($topic);
            $em->flush();
            return $this->redirectToRoute("admin_afficher_topics");

        }
        return $this->render('Admin/edit.html.twig', array(

            "form" => $form->createView()

        ));


    }

    public function deleteTopicAction(Request $request){

        $us = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        $id = $request->get("id");
        $topic = $this->getDoctrine()->getRepository(Topic::class)->findOneByuser($id);
        $topics = $this->getDoctrine()->getRepository(Topic::class)->find($id);
        $em->remove($topics);
        $em->flush();
        return $this->redirectToRoute('admin_afficher_topics');


    }

    public function deleteCommAction(Request $request){

        $em = $this->getDoctrine()->getManager();
        $commentaire = $em->getRepository(Commentaire::class)->find($request->get("id"));
        $em->remove($commentaire);
        $em->flush();
        return $this->redirectToRoute('admin_afficher_commentaires_reportes');

    }

    public function approuverAction(Request $request){

        $id=$request->get('id');
        $em = $this->getDoctrine()->getManager();
        $reclamation = $em->getRepository(Reclamation::class)->find($id);
        $reclamation->setEtat('approuve');
        $em->persist($reclamation);
        $em->flush();
        return $this->redirectToRoute('admin_afficher_reclamations');


    }

}
