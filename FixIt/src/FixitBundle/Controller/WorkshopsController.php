<?php

namespace FixitBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class WorkshopsController extends Controller
{
    public function indexAction()
    {
        $user=null;
        if( $this->container->get( 'security.authorization_checker' )->isGranted( 'IS_AUTHENTICATED_FULLY' ) )
        {
            $user = $this->container->get('security.token_storage')->getToken()->getUser();
        }

        return $this->render('@Fixit/Evenement/index.html.twig',array(
            'user'=> $user,
        ));
    }
}
