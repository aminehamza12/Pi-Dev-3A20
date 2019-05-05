<?php

namespace FixitBundle\Controller;

use FixitBundle\Entity\commande;
use FixitBundle\Entity\product;
use FixitBundle\Entity\notification;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FixitBundle\Service\HTML2PDF;

/**
 * Commande controller.
 *
 */
class commandeController extends Controller
{
    /**
     * Lists all commande entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $user=$this->getUser();
        $commandes = $em->getRepository('FixitBundle:commande')->findAll();

        return $this->render('commande/index.html.twig', array(
            'commandes' => $commandes,'user'=>$user
        ));
    }

    /**
     * Creates a new commande entity.
     *
     */
    public function newAction(Request $request,product $product)
    {
        $em = $this->getDoctrine()->getManager();
        $commande = new Commande();
        $notification = new notification();
        $notification->setDate(date_create(date("F j, Y, g:i a")));
        $notification->setEtat(0);
        $notification->setContenu('le client '.$this->getUser()->getNom().' veut reserver votre produit '.$product->getName());
        $notification->setUser($this->getUser());
        $notification->setProduct($product);
        $notification->setQuantity($_POST['num-product']);
        $product->setNbcommande($product->getNbcommande()+1);
        $em->persist($notification);
        $product = $em->getRepository('FixitBundle:product')->find($product);
        $user=$this->getUser();
            $em = $this->getDoctrine()->getManager();
            $commande->setProduct($product);
            $commande->setUser($user);
            $commande->setDelivery($product->getDelivery());
            $commande->setMontant($product->getPrice());
            $commande->setQuantity($_POST['num-product']);
            $commande->setDate(date_create(date("F j, Y, g:i a")));
            $em->persist($commande);
            $em->flush();
        $user=$this->getUser();
            return $this->redirectToRoute('commande_show', array('id' => $commande->getId(),'user'=>$user));

    }

    /**
     * Finds and displays a commande entity.
     *
     */
    public function showAction(commande $commande)
    {
        $deleteForm = $this->createDeleteForm($commande);
        $em = $this->getDoctrine()->getManager();
        $user=$this->getUser();
        $nbr=0;
        $nbr1 = $em->getRepository('FixitBundle:notification')->findBy(array('etat' => 0,'user' =>$user  ));
        foreach ($nbr1 as $n)
        {
            $nbr ++;
        }
        return $this->render('commande/show.html.twig', array(
            'commande' => $commande,'user'=>$user,
            'delete_form' => $deleteForm->createView(),
            'nbr' =>$nbr
        ));
    }

    /**
     * Displays a form to edit an existing commande entity.
     *
     */
    public function editAction(Request $request, commande $commande)
    {
        $deleteForm = $this->createDeleteForm($commande);
        $editForm = $this->createForm('FixitBundle\Form\commandeType', $commande);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('commande_edit', array('id' => $commande->getId()));
        }

        return $this->render('commande/edit.html.twig', array(
            'commande' => $commande,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a commande entity.
     *
     */
    public function deleteAction(Request $request, commande $commande)
    {
        $form = $this->createDeleteForm($commande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($commande);
            $em->flush();
        }

        return $this->redirectToRoute('commande_index');
    }

    /**
     * Creates a form to delete a commande entity.
     *
     * @param commande $commande The commande entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(commande $commande)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('commande_delete', array('id' => $commande->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
    public function pdfAction(Request $request,commande $commande)
    {
        $articles = [
            [
                'title' => $commande->getProduct()->getName(),
                'count' => $commande->getQuantity(),
                'price' => $commande->getMontant()
            ]

        ];
        $user1 = [
            [
                'user0' =>$commande->getUser()->getNom()
            ],
            [
                'email' =>$commande->getUser()->getEmail()
            ],
            [
                'user1' =>$commande->getProduct()->getUser()->getNom()
            ],
            [
                'email1' =>$commande->getProduct()->getUser()->getEmail()
            ],
            [
                'date' =>date_create(date("F j, Y, g:i a"))
            ]
            ,
            [
                'reference' =>$commande->getId()
            ]



        ];
        $snappy = $this->get("knp_snappy.pdf");
        //$snappy->setOption("encoding","UTF-8");
        $html = $this->renderView("pdf.html.twig",array(
            'articles'=> $articles,'remise' => 0,'tva' => 19.6 ,'frais_de_port','total' => 0,'user' => $user1
        ));
        $filename = "custom_pdf_from_twig";
        $user=$this->getUser();
        return new Response($snappy->getOutputFromHtml($html),
            200,
        array(
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="'.$filename.'.pdf"','user'=>$user
        )


        );

    }
    public function indexadminAction()
    {
        $em = $this->getDoctrine()->getManager();
        $user=$this->getUser();
        $commandes = $em->getRepository('FixitBundle:commande')->findAll();

        return $this->render('commande/index1.html.twig', array(
            'commandes' => $commandes,'user'=>$user
        ));
    }

    public function showadminAction(commande $commande)
    {
        $deleteForm = $this->createDeleteForm($commande);
        $em = $this->getDoctrine()->getManager();
        $user=$this->getUser();
        $nbr=0;
        $nbr1 = $em->getRepository('FixitBundle:notification')->findBy(array('etat' => 0 ));
        foreach ($nbr1 as $n)
        {
            $nbr ++;
        }
        return $this->render('commande/show1.html.twig', array(
            'commande' => $commande,'user'=>$user,
            'delete_form' => $deleteForm->createView(),
            'nbr' =>$nbr
        ));
    }


}
