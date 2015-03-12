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
		return $this->render('ABReservationZenithBundle:Ajax:tarif.html.twig', array(
        'tarif'=>$tarif
            ));
    } 

    public function getSeancesBySpectacleAction($id_spectacle){
    	$em = $this->getDoctrine()->getManager();
		$spectacle = $em->getRepository('ABReservationZenithBundle:Spectacle')->find($id_spectacle);
		return $this->render('ABReservationZenithBundle:Ajax:seances.html.twig', array(
        'seances'=>$spectacles->getSeances()
            ));
    }
}

?>