<?php

namespace BlogBundle\Controller;

use BlogBundle\Entity\Partner;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Partner controller.
 *
 */
class PartnerController extends Controller
{
    /**
     * Lists all partner entities.
     *
     */
    public function indexAction()
    {

        $em = $this->getDoctrine()->getManager();



        if($this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')){
            $partners = $em->getRepository('BlogBundle:Partner')->findAll();
            return $this->render('partner/index.html.twig', array(
                'partners' => $partners,
            ));
        }else{

            $industrielPartners = $em->getRepository('BlogBundle:Partner')->findByType('Partenariats industriels');
            $academicPartners = $em->getRepository('BlogBundle:Partner')->findByType('Partenariats académiques');
            $technologicPartners = $em->getRepository('BlogBundle:Partner')->findByType('Partenariats technologiques');

            $partners = $em->getRepository('BlogBundle:Partner')->findAll();
            $partnerCountries = array(array());
            //$partnerCountries[0] = array('string', 'string');
            $partnerCountries[0] = array('Country', 'Partner');
            $partnerCountries[1] = array('US', 'test');

            $count = 1;
            foreach ($partners as $partner){
                if (!in_array($partner->getLocation(), $partnerCountries)){
                    $partnerCountries[$count] = array($partner->getLocation(),$partner->getName());
                }else{
                    $partnerCountries["'".$partner->getLocation()."'"] =$partnerCountries["'".$partner->getLocation()."'"].",". $partner->getName();

                }
                $count ++;
            }



            return $this->render('partner/Front/index.html.twig', array(
                'industrielPartners' => $industrielPartners,
                'academicPartners' => $academicPartners,
                'technologicPartners' => $technologicPartners,
                'partnerCountries' => $partnerCountries,
            ));
        }


    }

    /**
     * Creates a new partner entity.
     *
     */
    public function newAction(Request $request)
    {
        $partner = new Partner();
        $form = $this->createForm('BlogBundle\Form\PartnerType', $partner);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->get('security.token_storage')->getToken()->getUser();
            $partner->setUser($user);
            $em = $this->getDoctrine()->getManager();
            $em->persist($partner);
            $em->flush();

            return $this->redirectToRoute('partner_show', array('id' => $partner->getId()));
        }

        return $this->render('partner/new.html.twig', array(
            'partner' => $partner,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a partner entity.
     *
     */
    public function showAction(Partner $partner)
    {

        $deleteForm = $this->createDeleteForm($partner);

        return $this->render('partner/show.html.twig', array(
            'partner' => $partner,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing partner entity.
     *
     */
    public function editAction(Request $request, Partner $partner)
    {
        $deleteForm = $this->createDeleteForm($partner);
        $editForm = $this->createForm('BlogBundle\Form\PartnerType', $partner);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('partner_edit', array('id' => $partner->getId()));
        }

        return $this->render('partner/edit.html.twig', array(
            'partner' => $partner,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a partner entity.
     *
     */
    public function deleteAction(Request $request, Partner $partner)
    {
        /*
        $form = $this->createDeleteForm($partner);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($partner);
            $em->flush();
        }
        */
        if($partner){
            $em = $this->getDoctrine()->getManager();
            $em->remove($partner);
            $em->flush();
        }

        return $this->redirectToRoute('partner_index');
    }

    /**
     * Creates a form to delete a partner entity.
     *
     * @param Partner $partner The partner entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Partner $partner)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('partner_delete', array('id' => $partner->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
