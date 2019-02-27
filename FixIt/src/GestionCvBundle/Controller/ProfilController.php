<?php

namespace GestionCvBundle\Controller;

use Doctrine\ORM\Query\ResultSetMapping;
use GestionCvBundle\Entity\Profil;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Profil controller.
 *
 */
class ProfilController extends Controller
{
    /**
     * Lists all profil entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $profils = $em->getRepository('GestionCvBundle:Profil')->findAll();

        return $this->render('profil/index.html.twig', array(
            'profils' => $profils,
        ));
    }
    public function profiladminAction()
    {
        $em = $this->getDoctrine()->getManager();

        $profils = $em->getRepository('GestionCvBundle:Profil')->findAll();

        return $this->render('profil/admin/show.html.twig', array(
            'profils' => $profils,
        ));
    }

    /**
     * Creates a new profil entity.
     *
     */
    public function newAction(Request $request)
    {
        $profil = new Profil();
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $form = $this->createForm('GestionCvBundle\Form\ProfilType', $profil);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $profil->setUser($user);
            $user->setIsprofil(1);
            $em->persist($profil);
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('profil_show', array('id' => $profil->getId()));
        }

        return $this->render('profil/new.html.twig', array(
            'profil' => $profil,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a profil entity.
     *
     */
    public function showAction(Profil $profil)
    {
        $deleteForm = $this->createDeleteForm($profil);

        return $this->render('profil/show.html.twig', array(
            'profil' => $profil,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    public function testAction(Profil $profil)
    {

        return $this->render('profil/test.html.twig', array(
            'profil' => $profil,
        ));
    }

    /**
     * Displays a form to edit an existing profil entity.
     *
     */
    public function editAction(Request $request, Profil $profil)
    {
        $deleteForm = $this->createDeleteForm($profil);
        $editForm = $this->createForm('GestionCvBundle\Form\ProfilType', $profil);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('profil_edit', array('id' => $profil->getId()));
        }

        return $this->render('profil/edit.html.twig', array(
            'profil' => $profil,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a profil entity.
     *
     */
    public function deleteAction(Request $request, Profil $profil)
    {
        $form = $this->createDeleteForm($profil);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($profil);
            $em->flush();
        }

        return $this->redirectToRoute('profil_index');
    }

    /**
     * Creates a form to delete a profil entity.
     *
     * @param Profil $profil The profil entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Profil $profil)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('profil_delete', array('id' => $profil->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    public function sideBarProfilAction(){
        $em = $this->getDoctrine()->getManager();
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $profil = $em->getRepository('GestionCvBundle:Profil')->findOneByUser($user);
        //dump($profil);die;
        return $this->render('profil/sideBarProfil.html.twig', array(
            'profil' => $profil,
        ));
    }
    public function renderProfilPhotoAction(){
        $em = $this->getDoctrine()->getManager();
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $profil = $em->getRepository('GestionCvBundle:Profil')->findOneByUser($user);
        //dump($profil);die;
        return $this->render('profil/renderProfilPhoto.html.twig', array(
            'profil' => $profil,
        ));
    }
    public function photobaseAction(){
        $em = $this->getDoctrine()->getManager();
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $profil = $em->getRepository('GestionCvBundle:Profil')->findOneByUser($user);
        //dump($profil);die;
        return $this->render('profil/photobase.html.twig', array(
            'profil' => $profil,
        ));
    }
    public function searchAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $requestString = $request->get('q');
        //$entities =  $em->getRepository('GestionCvBundle:Profil')->findEntitiesByString($requestString);
        $rsm = new ResultSetMapping();
        $em = $this->getDoctrine()->getManager();
        $rsm->addScalarResult('Logo','logo');

        $rsm->addScalarResult('Mobile','mobile');

        $rsm->addScalarResult('nom','nom');

        //$sql = "SELECT CAST(dateVisite AS date) FROM blog_views WHERE blog_id = 1 AND CAST(dateVisite AS date) = \"2019-02-23\" LIMIT 1";



        $query = $em->createNativeQuery

        ('SELECT Logo,Mobile,nom FROM profil as p , user as u WHERE u.id=p.user_id and u.nom LIKE :str',

            $rsm);
        $query->setParameter('str', '%'.$requestString.'%');
        $entities=$query->getResult();

        if(!$entities) {
            $result['entities']['error'] = "keine Einträge gefunden";
        } else {
            $result['entities'] = $this->getRealEntities($entities);
        }
        return new Response(json_encode($result));
    }
    public function getRealEntities($entities){
        foreach ($entities as $entity){
            $realEntities[$entity['nom']] = [$entity['logo'],$entity['mobile']];
        }
        return $realEntities;
    }
}
