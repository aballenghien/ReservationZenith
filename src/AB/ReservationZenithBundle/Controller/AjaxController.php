<?php

namespace AB\ReservationZenithBundle\Controller;

use JMS\SecurityExtraBundle\Annotation\Secure;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Response;
class AjaxController extends Controller
{

	public function getTarifWithPlaceAction($place, $id_spectacle){
		$em = $this->getDoctrine()->getManager();
		$tarif = $em->getRepository('ABReservationZenithBundle:Tarif')->getTarifByPlace($place, $id_spectacle);
		$serializer = $this->get('jms_serializer');
        $reports = $serializer->serialize($tarif, 'json');
        return new Response($reports);
    } 

    public function getSeancesBySpectacleAction($id_spectacle){
    	$em = $this->getDoctrine()->getManager();
		$spectacle = $em->getRepository('ABReservationZenithBundle:Spectacle')->find($id_spectacle);
        $serializer = $this->get('jms_serializer');
        $reports = $serializer->serialize($spectacle->getSeances(), 'json');
        return new Response($reports);
    }
}

?>