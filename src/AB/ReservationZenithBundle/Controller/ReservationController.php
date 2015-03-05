<?php

namespace AB\ReservationZenithBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AB\ReservationZenithBundle\Form\ReservationType;
use AB\ReservationZenithBundle\Entity\Reservation;
use AB\ConnexionBundle\Entity\User;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Symfony\Component\HttpFoundation\Request;

class reservationController extends Controller
{
/**
* @Secure(roles="ROLE_USER")
*/
    public function indexAction()
    {
        $user = $this->container->get('security.context')->getToken()->getUser();
        return $this->render('ABReservationZenithBundle:reservation:index.html.twig', array('user'=>$user
                // ...
            ));    }
/**
* @Secure(roles="ROLE_USER")
*/
    public function ajouterAction(Request $request)
    {
        $user = $this->container->get('security.context')->getToken()->getUser();
        $em = $this->getDoctrine()->getManager();
        $reservation = new Reservation();
        $reservation->setIdClientConcerne($user);
		$form = $this->createForm(new ReservationType(), $reservation);
        if($request->isMethod('POST')){
    		$form->handleRequest($this->getRequest());
    		if($form->isValid()){
    			$reservation = $form->getData();
    			$em->persist($reservation);
    			$em->flush($reservation);
    			$id = $reservation->getId();
    			return $this->redirect($this->get('router')->generate('voir_reservation',array('id'=>$id)));
    		}
        }
        return $this->render('ABReservationZenithBundle:Reservation:ajouter.html.twig', array(
        'form'=>$form->createView()
            ));    }
/**
* @Secure(roles="ROLE_USER")
*/
    public function voirAction($idClient,$id)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->container->get('security.context')->getToken()->getUser();
        $reservations = array();
        if($idClient != 0)
        {
           
            $client = $em->getRepository('ABConnexionBundle:User')->findOneById($idClient);
            if(!$client){
                throw $this->createNotFoundException('L\'utilisateur n\' r�serv� aucune s�ance');
            }
            $reservations = $em->getRepository('ABReservationZenithBundle:Reservation')->findByIdClientConcerne($client);
            if($id != 0)
            {
            	$reservation = $em->getRepository('ABReservationZenithBundle:Reservation')->findOneById($id);
                foreach($reservations as $e)
                {
                    if($e->id == $id)
                    {
                        $reservation = $e;
                    }

                }
                if($reservation)
                {
                        return $this->render('ABReservationZenithBundle:Reservation:details.html.twig', array(
                    'reservation'=>$reservation, 'user'=>$user
                    ));
                }
            }
        }else{
            if($id != 0){
                $reservation = $em->getRepository('ABReservationZenithBundle:Reservation')->findOneById($id);
                return $this->render('ABReservationZenithBundle:Reservation:details.html.twig', array(
                'reservation'=>$reservation, 'user'=>$user));
            }else{
                $reservations = $em->getRepository('ABReservationZenithBundle:Reservation')->findAll();
            }
        }
            
            return $this->render('ABReservationZenithBundle:Reservation:voir.html.twig', array(
            'reservations'=>$reservations, 'user'=>$user
                ));    
        
    }
/**
* @Secure(roles="ROLE_USER")
*/
    public function modifierAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $reservation = $em->getRepository('ABReservationZenithBundle:Reservation')->findOneById($id);
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

/**
* @Secure(roles="ROLE_ADMIN")
*/
    public function supprimerAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $reservation = $em->getRepository('ABReservationZenithBundle:Reservation')->findOneById($id);
        $em->remove($reservation);
        $em->flush();
        $reservations = $em->getRepository('ABReservationZenithBundle:Reservation')->findAll();		
			
        return $this->render('ABReservationZenithBundle:Reservation:supprimer.html.twig', array(
        'reservations'=>$reservations
            ));     
            }

}
