<?php

namespace ForumBundle\Controller;
use JMS\Serializer\Serializer;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use ForumBundle\Entity\Commentaire;
use ForumBundle\Entity\Topic;


class CommentaireController extends Controller
{
    public function ajouterAction(Request $request){
        $em = $this->getDoctrine()->getManager();
        $id= $request->get('id');
        $us = $this->getUser();
        $topic = $em->getRepository(Topic::class)->find($id);
        $commentaires = $em->getRepository(Commentaire::class)->diffDate($request->get("id"));
        if($request->isMethod("POST")){
            $comm = $request->get("idcomm");
            $commentaire = new Commentaire();
            $commentaire->setContenu($comm);
            $commentaire->setIdTopic($topic);
            $commentaire->setUser($us);
            $commentaire->setPost(new \DateTime('now'));

            $em->persist($commentaire);
            $em->flush();
            return $this->redirectToRoute("details",array(

                "id"=>$id

            ));

        }


    }



    public function reportAction(Request $request){

        $em = $this->getDoctrine()->getManager();
        $comm =$em->getRepository(Commentaire::class)->find($request->get("idc"));
        $comm->setEtatCommentaire("reported");
        $em->persist($comm);
        $em->flush();
        return $this->redirectToRoute('details',array(

            "id"=>$request->get("idt")

        ));



    }

    public function deleteAction(Request $request){

        $em = $this->getDoctrine()->getManager();
        $commentaire = $this->getDoctrine()->getRepository('ForumBundle:Commentaire')->find($request->get("idc"));
        //dump($commentaire);die;

        $em->remove($commentaire);
        $em->flush();
        return $this->redirectToRoute('details',array(
            "id" =>$request->get("idt")));

    }
}
