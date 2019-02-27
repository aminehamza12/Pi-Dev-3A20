<?php

namespace FixitBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{

    public function indexAction()
    {

        if ($this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')){
            return $this->redirectToRoute('admin_homepage');
        }

        return $this->render('@Fixit/Default/index.html.twig');
    }

    public function indexAdminAction()
    {

        if ($this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')){

            return $this->render('@Fixit/back/index.html.twig');
        }else{

            return $this->redirectToRoute('fixit_404');
        }

    }

    public function wrongAction()
    {
        if ($this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')){
            return $this->redirectToRoute('admin_homepage');
        }

        return $this->render('@Fixit/Default/404.html.twig');
    }
}
