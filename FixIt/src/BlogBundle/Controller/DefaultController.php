<?php

namespace BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('@Blog/FrontOffice/index.html.twig');
    }

    public function adminIndexAction()
    {
        return $this->render('@Blog/BackOffice/index.html.twig');
    }
}
