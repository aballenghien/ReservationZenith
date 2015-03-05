<?php

namespace AB\ReservationZenithBundle\Controller;

use JMS\SecurityExtraBundle\Annotation\Secure;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Session\Session;
class DefaultController extends Controller
{

    public function indexAction()
    {
        
        return $this->render('ABReservationZenithBundle:Default:index.html.twig');
    }

    public function gestionLangueAction($locale, $vue){

        $this->get('session')->set('_locale', $locale);
        return $this->redirect($this->get('router')->generate($vue));
    }


/**
* @Secure(roles="ROLE_ADMIN")
*/
    public function backofficeAction(){
    	return $this->render('ABReservationZenithBundle:Default:backoffice.html.twig');
    }

/**
* @Secure(roles="ROLE_USER")
*/
	public function espaceclientAction(){
    	return $this->render('ABReservationZenithBundle:Default:espaceclient.html.twig');
    }

}
