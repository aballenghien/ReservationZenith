<?php

namespace AB\ReservationZenithBundle\Controller;

use JMS\SecurityExtraBundle\Annotation\Secure;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('ABReservationZenithBundle:Default:index.html.twig');
    }


/**
* @Secure(roles="ROLE_ADMIN")
*/
    public function backofficeAction(){
    	return $this->render('ABReservationZenithBundle:Default:backoffice.html.twig');
    }
}
