<?php

namespace AB\ReservationZenithBundle\Controller;

use JMS\SecurityExtraBundle\Annotation\Secure;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Response;
class DefaultController extends Controller
{

    public function indexAction()
    {

        $xml = simplexml_load_file('fluxrss.rss');
        $channel = $xml->channel;
        $items = $channel->item;
        
        return $this->render('ABReservationZenithBundle:Default:index.html.twig',array('items'=>$items,'channel'=>$channel));
    }

    public function gestionLangueAction($locale, $vue){

        $this->get('session')->set('_locale', $locale);
        //return $this->redirect($this->get('router')->generate($vue));
        return new Response($this->get('session')->get('_locale'));
    }

    public function gestionTheme($theme, $vue){

        $this->get('session')->set('theme', $theme);
        
        $referer = $this->getRequest()->headers->get('referer');
        return $this->redirect($referer);
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
