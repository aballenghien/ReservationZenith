<?php

namespace AB\ReservationZenithBundle\Controller;

use JMS\SecurityExtraBundle\Annotation\Secure;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Response;
class AjaxController extends Controller
{

    // charge la page Ajax permettant d'afficher le tarif associé au numéro de place fourni par l'utilisateur
	public function getTarifWithPlaceAction($place, $id_spectacle){
		$em = $this->getDoctrine()->getManager();
		$tarif = $em->getRepository('ABReservationZenithBundle:Tarif')->getTarifByPlace($place, $id_spectacle);
		$serializer = $this->get('jms_serializer');
        $reports = $serializer->serialize($tarif, 'json');
        return new Response($reports);
    } 

    // charge la page ajax au format json contenant toutes les séances correspondant à un spectacle
    public function getSeancesBySpectacleAction($id_spectacle){
    	$em = $this->getDoctrine()->getManager();
		$spectacle = $em->getRepository('ABReservationZenithBundle:Spectacle')->find($id_spectacle);
        $serializer = $this->get('jms_serializer');
        $reports = $serializer->serialize($spectacle->getSeances(), 'json');
        return new Response($reports);
    }
}

?>