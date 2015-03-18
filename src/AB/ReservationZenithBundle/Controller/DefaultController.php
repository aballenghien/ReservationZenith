<?php

namespace AB\ReservationZenithBundle\Controller;

use JMS\SecurityExtraBundle\Annotation\Secure;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
class DefaultController extends Controller
{

    public function indexAction()
    {

        $xml = simplexml_load_file('fluxrss.rss');
        $channel = $xml->channel;
        $items = $channel->item;
        
        return $this->render('ABReservationZenithBundle:Default:index.html.twig',array('items'=>$items,'channel'=>$channel));
    }

    public function gestionLangueAction($langue, $vue, Request $request){

        $this->get('session')->set('_locale', $langue);
        //$request->attributes->set('_locale',$locale);
        $request->setLocale($this->get('session')->get('_locale'));
        return $this->redirect($this->get('router')->generate($vue));
        //return new Response($this->get('session')->get('_locale'));
    }

    public function gestionThemeAction($theme, $vue){

        $this->get('session')->set('theme', $theme);
        
        //$referer = $this->getRequest()->headers->get('referer');
        //return new Response($this->get('session')->get('theme'));
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
