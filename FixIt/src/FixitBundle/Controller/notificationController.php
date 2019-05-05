<?php

namespace FixitBundle\Controller;

use FixitBundle\Entity\notification;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Notification controller.
 *
 */
class notificationController extends Controller
{
    /**
     * Lists all notification entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $notifications = $em->getRepository('FixitBundle:notification')->findAll();
        $nbr=0;
        $nbr1 = $em->getRepository('FixitBundle:notification')->findBy(array('etat' => 0 , 'user' =>$user ));
        foreach ($nbr1 as $n)
        {
            $nbr ++;
        }
        return $this->render('notification/index.html.twig', array(
            'notifications' => $notifications,'user' => $user,'nbr' => $nbr
        ));
    }

    /**
     * Creates a new notification entity.
     *
     */
    public function newAction(Request $request)
    {
        $notification = new Notification();
        $form = $this->createForm('FixitBundle\Form\notificationType', $notification);
        $form->handleRequest($request);
        $user = $this->getUser();
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($notification);
            $em->flush();

            return $this->redirectToRoute('notification_show', array('id' => $notification->getId(),'user' => $user));
        }

        return $this->render('notification/new.html.twig', array(
            'notification' => $notification,
            'form' => $form->createView(),'user' => $user
        ));
    }

    /**
     * Finds and displays a notification entity.
     *
     */
    public function showAction(notification $notification)
    {
        $deleteForm = $this->createDeleteForm($notification);
        $user = $this->getUser();
        return $this->render('notification/show.html.twig', array(
            'notification' => $notification,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing notification entity.
     *
     */
    public function editAction(Request $request, notification $notification)
    {
        $deleteForm = $this->createDeleteForm($notification);
        $editForm = $this->createForm('FixitBundle\Form\notificationType', $notification);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('notification_edit', array('id' => $notification->getId()));
        }

        return $this->render('notification/edit.html.twig', array(
            'notification' => $notification,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a notification entity.
     *
     */
    public function deleteAction(Request $request, notification $notification)
    {
        $form = $this->createDeleteForm($notification);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($notification);
            $em->flush();
        }

        return $this->redirectToRoute('notification_index');
    }

    /**
     * Creates a form to delete a notification entity.
     *
     * @param notification $notification The notification entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(notification $notification)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('notification_delete', array('id' => $notification->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
    public function validerAction(Request $request ,notification $notification)
    {

        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $notifications = $em->getRepository('FixitBundle:notification')->findAll();
        $nbr=0;
        $notification->getProduct()->setQuantity($notification->getProduct()->getQuantity()-$notification->getQuantity());
        $nbr1 = $em->getRepository('FixitBundle:notification')->findBy(array('etat' => 0 ));
        foreach ($nbr1 as $n)
        {
            $nbr ++;
        }
        // $this->get('avator_turbosms.turbosms')->send("test", "+21627026614");
        // Authorisation details.
        $username = "nadim.jemai@esprit.tn";
        $hash = "47bc098e1483a3f357942a4492f3fe97ca062ed2f5c0080260ab0f487a8cc487";

        // Config variables. Consult http://api.txtlocal.com/docs for more info.
        $test = "0";

        // Data for text message. This is the text message data.
        $sender = "FixiT"; // This is who the message appears to be from.
        $numbers = "00216".$notification->getUser()->getTel(); // A single number or a comma-seperated list of numbers
        $message ="Bonsoir Mr.".$notification->getProduct()->getUser()->getNom()." votre demande de reservation du produit à été confirmer pour
         le produit ".$notification->getProduct()->getName().", vous devez le contactez sur son num ".$notification->getProduct()->getTel()." Merci . Service commerciale FixIt";
        // 612 chars or less
        // A single number or a comma-seperated list of numbers
        $message = urlencode($message);
        $data = "username=".$username."&hash=".$hash."&message=".$message."&sender=".$sender."&numbers=".$numbers."&test=".$test;
        $ch = curl_init('http://api.txtlocal.com/send/?');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch); // This is the result from the API
        curl_close($ch);
        //end
        $notification->setEtat(1);
        $em->flush();
        return $this->render('notification/index.html.twig', array(
            'notifications' => $notifications,'user' => $user,'nbr' => $nbr
        ));
    }
    public function rejeterAction(Request $request ,notification $notification)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $notifications = $em->getRepository('FixitBundle:notification')->findAll();
        $nbr=0;
        $nbr1 = $em->getRepository('FixitBundle:notification')->findBy(array('etat' => 0 ));
        foreach ($nbr1 as $n)
        {
            $nbr ++;
        }
        $notification->setEtat(-1);
        $em->persist($notification);
        $em->flush();
        return $this->render('notification/index.html.twig', array(
            'notifications' => $notifications,'user' => $user,'nbr' => $nbr
        ));
    }
}
