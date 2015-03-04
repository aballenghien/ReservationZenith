<?php

namespace AB\ConnexionBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('ABConnexionBundle:Default:index.html.twig', array('name' => $name));
    }
}
