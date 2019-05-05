<?php

namespace FixitBundle\Controller;

<<<<<<< HEAD
use FixitBundle\Entity\categorieifixit;
use FixitBundle\Entity\Likes;
use FixitBundle\Entity\Particpant;
use FixitBundle\Entity\Rating;
use FixitBundle\Entity\Workshops;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use FixitBundle\Entity\Feedback;
use FixitBundle\Entity\Recomended;
use Symfony\Component\Validator\Constraints\DateTime;

/**
 * Workshop controller.
 *
 */
class WorkshopsController extends Controller
{
    /**
     * Lists all workshop entities.
     *
     */
    public function indexAction(Request $request)
=======
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class WorkshopsController extends Controller
{
    public function indexAction()
>>>>>>> 1cbb02caab7bb0b2d88eca07f7e88dcb96ab6a29
    {
        $user=null;
        if( $this->container->get( 'security.authorization_checker' )->isGranted( 'IS_AUTHENTICATED_FULLY' ) )
        {
            $user = $this->container->get('security.token_storage')->getToken()->getUser();
        }

<<<<<<< HEAD
        $em = $this->getDoctrine()->getManager();
        $workshops = $em->getRepository('FixitBundle:Workshops')->findAll();
        $Likes=$em->getRepository(Likes::class)->findBy(array('user'=>$user->getId()));
        $participations=$em->getRepository(Particpant::class)->findBy(array(
            'idUser'=>$user->getId(),
        ));
        $my_array=array();
        foreach ($Likes as $like)
        {
            array_push($my_array,$like->getWorkshop()->getId());
        }

        $my_array2=array();
        foreach ($participations as $participation)
        {
            array_push($my_array2,$participation->getIdworkshop()->getId());
        }
        $em    = $this->get('doctrine.orm.entity_manager');
        $dql   = "SELECT a FROM FixitBundle:Workshops a";
        $query = $em->createQuery($dql);

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            2/*limit per page*/
        );

        //affichage de recomendation
        $cat=$this->getDoctrine()->getRepository(Recomended::class)->findAll();
        $max=reset($cat);
        foreach ($cat as $value)
        {
            if($max->getValue()<$value->getValue())
            {
                $max=$value;
            }
        }
        $recomended=$this->getDoctrine()->getRepository(Workshops::class)->findBy(array(
            'categorie'=>$max->getCategorie(),
        ));

        return $this->render('@Fixit/workshops/index.html.twig', array(
            'workshops' => $pagination,
            'liked'=>$my_array,
            'participation'=>$my_array2,
            'recomended'=>$recomended,
        ));
    }
    public function indexAdminAction()
    {

        $em = $this->getDoctrine()->getManager();

        $workshops = $em->getRepository('FixitBundle:Workshops')->findAll();

        return $this->render('@Fixit/workshops/indexAdmin.html.twig', array(
            'workshops' => $workshops,
        ));
    }

    /**
     * Creates a new workshop entity.
     *
     */
    public function newAction(Request $request)
    {

        $workshop = new Workshops();
        $form = $this->createForm('FixitBundle\Form\WorkshopsType', $workshop);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $workshop->setNbrjaime(0);
            $workshop->setVu(0);
            $workshop->setNbrparticipant(0);
            $workshop->setRating(0);
            $workshop->setLat("0");
            $workshop->setLong("0");
            $em->persist($workshop);
            $em->flush();
            $workshops=$this->getDoctrine()->getRepository(Workshops::class)->findAll();

            return $this->redirectToRoute('workshops_indexAdmin');
        }

        return $this->render('@Fixit/workshops/new.html.twig', array(
            'workshop' => $workshop,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a workshop entity.
     *
     */
    public function showAction(Workshops $workshop)
    {
        $user=null;
        if( $this->container->get( 'security.authorization_checker' )->isGranted( 'IS_AUTHENTICATED_FULLY' ) )
        {
            $user = $this->container->get('security.token_storage')->getToken()->getUser();
        }
        $em=$this->getDoctrine()->getManager();
        $feedbacks=$this->getDoctrine()->getRepository(Feedback::class)->findBy(array(
            'workshop'=>$workshop->getId(),
        ));
        $related=$this->getDoctrine()->getRepository(Workshops::class)->findBy(array('categorie'=>$workshop->getCategorie()));
        $related=array_diff($related,array($workshop));
        //systme de recommendation show
        $categorie=$this->getDoctrine()->getRepository(categorieifixit::class)->find($workshop->getCategorie());
        $recomended=$this->getDoctrine()->getRepository(Recomended::class)->findOneBy(array(
            'user'=>$user->getId(),
            'categorie'=>$categorie
        ));
        if($recomended==null)
        {
            $recomended=new Recomended();
            $recomended->setUser($user);
            $recomended->setCategorie($categorie);
            $recomended->setValue(1);
            $this->getDoctrine()->getManager()->persist($recomended);
        }
        else
        {
            $recomended->setValue($recomended->getValue()+1);
        }
        $em->flush();
        $feedback=new Feedback();
        $form = $this->createForm('FixitBundle\Form\FeedbackType', $feedback);
        return $this->render('@Fixit/workshops/show.html.twig', array(
            'workshop' => $workshop,
            'related'=>$related,
            'feedbacks'=>$feedbacks,
        ));
    }

    /**
     * Displays a form to edit an existing workshop entity.
     *
     */
    public function editAction(Request $request, Workshops $workshop)
    {

        $deleteForm = $this->createDeleteForm($workshop);
        $editForm = $this->createForm('FixitBundle\Form\WorkshopsType', $workshop);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('workshops_indexAdmin', array('id' => $workshop->getId()));
        }

        return $this->render('@Fixit/workshops/edit.html.twig', array(
            'workshop' => $workshop,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a workshop entity.
     *
     */
    public function deleteAction(Request $request, Workshops $workshop)
    {

        $form = $this->createDeleteForm($workshop);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($workshop);
            $em->flush();
        }

        return $this->redirectToRoute('workshops_indexAdmin');
    }

    /**
     * Creates a form to delete a workshop entity.
     *
     * @param Workshops $workshop The workshop entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Workshops $workshop)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('workshops_delete', array('id' => $workshop->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }



    public function CommentAction($id,Request $request)
    {
        $user=null;
        if( $this->container->get( 'security.authorization_checker' )->isGranted( 'IS_AUTHENTICATED_FULLY' ) )
        {
            $user = $this->container->get('security.token_storage')->getToken()->getUser();
        }
        $data=$request->getContent();
        $data=json_decode($data,true);
        $workshopfinal=$this->getDoctrine()->getRepository(Workshops::class)->find($id);
        $workshopfinal->setVu($workshopfinal->getVu()+1);
        $subject=$data['subject'];
        $description=$data['description'];
        $workshop=$this->getDoctrine()->getRepository(Workshops::class)->find($id);
        $em=$this->getDoctrine()->getManager();
        $feedback=new Feedback();
        $feedback->setUser($user);
        $feedback->setWorkshop($workshop);
        $feedback->setSubject($subject);
        $feedback->setDescription($description);
        $em->persist($feedback);
        $em->flush();
        $feedbacks=$this->getDoctrine()->getRepository(Feedback::class)->findBy(array(
            'workshop'=>$id,
        ));
        $data=array(
            'subject'=>$subject,
            'description'=>$description,
            'nbr'=>count($feedbacks),
            'username'=>$user->getNom(),
            'userlastname'=>$user->getPrenom(),
        );
        $response=new JsonResponse();
        $response->setData(array('data'=>$data),200);
        return $response;


    }

    public function LikeAction($id)
    {

            $user=null;
            if( $this->container->get( 'security.authorization_checker' )->isGranted( 'IS_AUTHENTICATED_FULLY' ) )
            {
                $user = $this->container->get('security.token_storage')->getToken()->getUser();
            }
            $likes=$this->getDoctrine()->getRepository(Likes::class)->findOneBy(array(
                'user'=>$user->getId(),
                'workshop'=>$id,
            ));
            $workshop=$this->getDoctrine()->getRepository(Workshops::class)->find($id);
        //systme de recommendation like
        $categorie=$this->getDoctrine()->getRepository(categorieifixit::class)->find($workshop->getCategorie());
        $recomended=$this->getDoctrine()->getRepository(Recomended::class)->findOneBy(array(
            'user'=>$user->getId(),
            'categorie'=>$categorie
        ));


            if($likes == null)
            {
                $workshop=new Workshops();
                $workshop=$this->getDoctrine()->getRepository(Workshops::class)->find($id);
                $workshop->setNbrjaime($workshop->getNbrjaime()+1);
                $like=new Likes();
                $like->setUser($user);
                $like->setWorkshop($workshop);
                $this->getDoctrine()->getManager()->persist($like);
                $this->getDoctrine()->getManager()->flush();
                $data=array('type'=>'1','nbr'=>$workshop->getNbrjaime());
                if($recomended==null)
                {
                    $recomended=new Recomended();
                    $recomended->setUser($user);
                    $recomended->setCategorie($categorie);
                    $recomended->setValue(5);
                    $this->getDoctrine()->getManager()->persist($recomended);
                }
                else
                {
                    $recomended->setValue($recomended->getValue()+5);
                }
            }
            else
            {
                $workshop=new Workshops();
                $workshop=$this->getDoctrine()->getRepository(Workshops::class)->find($id);
                $workshop->setNbrjaime($workshop->getNbrjaime()-1);
                $this->getDoctrine()->getManager()->remove($likes);
                $this->getDoctrine()->getManager()->flush();
                $data=array('type'=>'0','nbr'=>$workshop->getNbrjaime());
                if($recomended==null)
                {
                    $recomended=new Recomended();
                    $recomended->setUser($user);
                    $recomended->setCategorie($categorie);
                    $recomended->setValue(0);
                    $this->getDoctrine()->getManager()->persist($recomended);
                }
                else
                {
                    $recomended->setValue($recomended->getValue()-5);
                }
            }
            $this->getDoctrine()->getManager()->flush();
            $response=new JsonResponse();
            $response->setData(array('data'=>$data),200);
            return $response;

    }

    public function ParticipationAction($id)
    {
        $user=null;
        if( $this->container->get( 'security.authorization_checker' )->isGranted( 'IS_AUTHENTICATED_FULLY' ) )
        {
            $user = $this->container->get('security.token_storage')->getToken()->getUser();
        }
        $participations=$this->getDoctrine()->getRepository(Particpant::class)->findOneBy(array(
            'idUser'=>$user->getId(),
            'idworkshop'=>$id,
        ));
        $workshop=$this->getDoctrine()->getRepository(Workshops::class)->find($id);
        //systme de recommendation participation
        $categorie=$this->getDoctrine()->getRepository(categorieifixit::class)->find($workshop->getCategorie());
        $recomended=$this->getDoctrine()->getRepository(Recomended::class)->findOneBy(array(
            'user'=>$user->getId(),
            'categorie'=>$categorie
        ));
        if($participations==null)
        {
            $workshop->setNbrparticipant($workshop->getNbrparticipant()+1);
            $participation=new Particpant();
            $participation->setIdUser($user);
            $participation->setIdworkshop($workshop);
            $this->getDoctrine()->getManager()->persist($participation);
            $this->getDoctrine()->getManager()->flush();
            $data=array('type'=>'1','nbr'=>$workshop->getNbrparticipant());
            if($recomended==null)
            {
                $recomended=new Recomended();
                $recomended->setUser($user);
                $recomended->setCategorie($categorie);
                $recomended->setValue(10);
                $this->getDoctrine()->getManager()->persist($recomended);
            }
            else
            {
                $recomended->setValue($recomended->getValue()+10);
            }
        }
        else
        {

            $workshop->setNbrparticipant($workshop->getNbrparticipant()-1);
            $this->getDoctrine()->getManager()->remove($participations);
            $this->getDoctrine()->getManager()->flush();
            $data=array('type'=>'0','nbr'=>$workshop->getNbrparticipant());
            if($recomended==null)
            {
                $recomended=new Recomended();
                $recomended->setUser($user);
                $recomended->setCategorie($categorie);
                $recomended->setValue(0);
                $this->getDoctrine()->getManager()->persist($recomended);
            }
            else
            {
                $recomended->setValue($recomended->getValue()-10);
            }
        }
        $this->getDoctrine()->getManager()->flush();
        $response=new JsonResponse();
        $response->setData(array('data'=>$data),200);
        return $response;

    }

    public function RatingAction($id,Request $request)
    {
        $user=null;
        if( $this->container->get( 'security.authorization_checker' )->isGranted( 'IS_AUTHENTICATED_FULLY' ) )
        {
            $user = $this->container->get('security.token_storage')->getToken()->getUser();
        }
        $rating=$this->getDoctrine()->getRepository(Rating::class)->findOneBy(array(
            'user'=>$user->getId(),
            'workshop'=>$id,
        ));
        $data=$request->getContent();
        $data=json_decode($data,true);
        $ratingvalue=$data['value'];

        $workshop=$this->getDoctrine()->getRepository(Workshops::class)->find($id);

        if($rating==null)
        {
            $rating=new Rating();
            $ratings=$this->getDoctrine()->getRepository(Rating::class)->findBy(array(
                'workshop'=>$workshop,
            ));
            $workshopratefinal=($workshop->getRating()*count($ratings)+$ratingvalue)/(count($ratings)+1);
            $workshop->setRating($workshopratefinal);
            $rating->setUser($user);
            $rating->setWorkshop($workshop);
            $rating->setValue($ratingvalue);
            $this->getDoctrine()->getManager()->persist($rating);
            $this->getDoctrine()->getManager()->flush();
            $data=array('type'=>'1','nbr'=>$workshop->getRating());
        }
        else
        {
            if($ratingvalue>=$rating->getValue())
            {
                $type=2;
            }
            else
            {
                $type=0;
            }
            $rating->setValue($ratingvalue);
            $this->getDoctrine()->getManager()->flush();
            $ratings=$this->getDoctrine()->getRepository(Rating::class)->findBy(array(
                'workshop'=>$workshop,
            ));
            $workshopratefinal=0;
            foreach ($ratings as $rate)
            {
                $workshopratefinal=$rate->getValue()+$workshopratefinal;
            }
            $workshop->setRating($workshopratefinal/count($ratings));
            $this->getDoctrine()->getManager()->flush();
            $data=array('type'=>$type,'nbr'=>$workshop->getRating());
        }
        $response =new JsonResponse();
        $response->setData(array('data'=>$data),200);
        return $response;
    }

    public function GetDataAction()
    {
        $workshops=$this->getDoctrine()->getRepository(Workshops::class)->findAll();
        $response =new JsonResponse();
        $lat=array();
        $long=array();
        foreach ($workshops as $workshop)
        {
            array_push($lat,$workshop->getLat());
            array_push($long,$workshop->getLong());
        }
        $data=json_encode($workshops);
        $response->setData(array('lat'=>$lat,'long'=>$long),200);
        return $response;
    }



    
=======
        return $this->render('@Fixit/Evenement/index.html.twig',array(
            'user'=> $user,
        ));
    }
>>>>>>> 1cbb02caab7bb0b2d88eca07f7e88dcb96ab6a29
}
