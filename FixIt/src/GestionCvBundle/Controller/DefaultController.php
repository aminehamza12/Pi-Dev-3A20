<?php

namespace GestionCvBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('@GestionCv/Default/index.html.twig');
    }
}
