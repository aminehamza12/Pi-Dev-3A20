<?php

namespace GestionCvBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('GestionCvBundle:Default:index.html.twig');
    }
}
