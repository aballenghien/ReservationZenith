<?php

namespace AB\ReservationZenithBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AB\ReservationZenithBundle\Form\ReservationType;
use AB\ReservationZenithBundle\Entity\Reservation;

class reservationController extends Controller
{
    public function indexAction()
    {
        return $this->render('ABReservationZenithBundle:reservation:index.html.twig', array(
                // ...
            ));    }

    public function ajouterAction()
    {
        $em = $this->getDoctrine()->getManager();
		$form = $this->createForm(new ReservationType(), new Reservation());
		$form->handleRequest($this->getRequest());
		if($form->isValid()){
			$reservation = $form->getData();
			$em->persist($reservation);
			$em->flush($reservation);
			$id = $reservation->getId();
			return $this->redirect($this->get('router')->generate('voir_reservation',array('id'=>$id)));
		}
        return $this->render('ABReservationZenithBundle:Reservation:ajouter.html.twig', array(
        'form'=>$form->createView()
            ));    }

    public function voirAction($id)
    {
        $em = $this->getDoctrine()->getManager();
		$reservations = array();
		if($id != 0){
			$tarif = $em->getRepository('ABReservationZenithBundle:Reservation')->findOneById($id);
			array_push($reservations,$reservation);
		}else{
			$reservations = $em->getRepository('ABReservationZenithBundle:Reservation')->findAll();
		}
			
        return $this->render('ABReservationZenithBundle:Reservation:voir.html.twig', array(
        'reservations'=>$reservations
            ));    }

    public function modifierAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $tarif = $em->getRepository('ABReservationZenithBundle:Reservation')->findOneById($id);
		$form = $this->createForm(new ReservationType(), $reservation);
		$form->handleRequest($this->getRequest());
		if($form->isValid()){
			$reservation= $form->getData();
			$em->persist($reservation);
			$em->flush();
			$id = $reservation->getId();
			return $this->redirect($this->get('router')->generate('voir_reservation',array('id'=>0)));
		}
        return $this->render('ABReservationZenithBundle:Reservation:modifier.html.twig', array(
        'form'=>$form->createView()
            ));    }

    public function supprimerAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $reservation = $em->getRepository('ABReservationZenithBundle:Tarif')->findOneById($id);
        $em->remove($reservation);
        $em->flush();
        $tarifs = $em->getRepository('ABReservationZenithBundle:Reservation')->findAll();		
			
        return $this->render('ABReservationZenithBundle:Reservation:voir.html.twig', array(
        'reservations'=>$reservations
            ));     }

}
