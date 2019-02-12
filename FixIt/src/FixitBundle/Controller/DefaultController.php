<?php

namespace FixitBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{

    public function indexAction()
    {
        $user=null;
        if( $this->container->get( 'security.authorization_checker' )->isGranted( 'IS_AUTHENTICATED_FULLY' ) )
        {
            $user = $this->container->get('security.token_storage')->getToken()->getUser();
        }
        return $this->render('@Fixit/Default/index.html.twig',array('user'=>$user));
    }

    public function indexAdminAction()
    {
        $user=null;
        if( $this->container->get( 'security.authorization_checker' )->isGranted( 'IS_AUTHENTICATED_FULLY' ) )
        {
            $user = $this->container->get('security.token_storage')->getToken()->getUser();
        }
        if(in_array('ROLE_ADMIN',$user->getRoles()))
        {
            return $this->render('@Fixit/back/index.html.twig',array('user'=>$user));
        }
        return $this->redirectToRoute('fixit_404');
    }

    public function wrongAction()
    {
        $user=null;
        if( $this->container->get( 'security.authorization_checker' )->isGranted( 'IS_AUTHENTICATED_FULLY' ) )
        {
            $user = $this->container->get('security.token_storage')->getToken()->getUser();
        }

        return $this->render('@Fixit/Default/404.html.twig',array('user'=>$user));
    }
}
