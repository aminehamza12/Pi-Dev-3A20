<?php

namespace FixitBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{

    public function indexAction()
    {
<<<<<<< HEAD
        $user=null;
        if( $this->container->get( 'security.authorization_checker' )->isGranted( 'IS_AUTHENTICATED_FULLY' ) )
        {
            $user = $this->container->get('security.token_storage')->getToken()->getUser();
        }
        if(in_array('ROLE_ADMIN',$user->getRoles()))
        {
            return $this->redirectToRoute('admin_homepage');
        }
=======

        if ($this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')){
            return $this->redirectToRoute('admin_homepage');
        }

>>>>>>> 1cbb02caab7bb0b2d88eca07f7e88dcb96ab6a29
        return $this->render('@Fixit/Default/index.html.twig');
    }

    public function indexAdminAction()
    {
<<<<<<< HEAD
        $user=null;
        if( $this->container->get( 'security.authorization_checker' )->isGranted( 'IS_AUTHENTICATED_FULLY' ) )
        {
            $user = $this->container->get('security.token_storage')->getToken()->getUser();
        }
        if(in_array('ROLE_ADMIN',$user->getRoles()))
        {
            return $this->render('@Fixit/back/index.html.twig');
        }
        return $this->redirectToRoute('fixit_404');
=======

        if ($this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')){

            return $this->render('@Fixit/back/index.html.twig');
        }else{

            return $this->redirectToRoute('fixit_404');
        }

>>>>>>> 1cbb02caab7bb0b2d88eca07f7e88dcb96ab6a29
    }

    public function wrongAction()
    {
<<<<<<< HEAD

        return $this->render('@Fixit/Default/404.html.twig');
    }

    public function navBarAction(){
        $em = $this->getDoctrine()->getManager();
        $blogCategories = $em->getRepository('BlogBundle:BlogCategorie')->findAll();
        return $this->render('navbarFront.html.twig', array(
            'blogCategories' => $blogCategories,
        ));
    }
=======
        if ($this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')){
            return $this->redirectToRoute('admin_homepage');
        }

        return $this->render('@Fixit/Default/404.html.twig');
    }
>>>>>>> 1cbb02caab7bb0b2d88eca07f7e88dcb96ab6a29
}
