<?php

namespace AB\ReservationZenithBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AB\ReservationZenithBundle\Form\SeanceType;
use AB\ReservationZenithBundle\Entity\Seance;

class SeanceController extends Controller
{
    public function indexAction()
    {
		
        return $this->render('ABReservationZenithBundle:Seance:index.html.twig', array(
                // ...
            ));    }

    public function ajouterAction()
    {
		$em = $this->getDoctrine()->getManager();
		$form = $this->createForm(new SeanceType(), new Seance());
		$form->handleRequest($this->getRequest());
		if($form->isValid()){
			$seance = $form->getData();
			$em->persist($seance);
			$em->flush();
			$id = $seance->getId();
			return $this->redirect($this->get('router')->generate('voir_seance',array('id'=>$id)));
		}
        return $this->render('ABReservationZenithBundle:Seance:ajouter.html.twig', array(
                'form'=>$form->createView()
            ));    }

    public function modifierAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $seance = $em->getRepository('ABReservationZenithBundle:Seance')->findOneById($id);
		$form = $this->createForm(new SeanceType(), $seance);
		$form->handleRequest($this->getRequest());
		if($form->isValid()){
			$seance = $form->getData();
			$em->persist($seance);
			$em->flush($seance);
			$id = $seance->getId();
			return $this->redirect($this->get('router')->generate('voir_seance',array('id'=>0)));
		}
        return $this->render('ABReservationZenithBundle:Seance:modifier.html.twig', array(
        'form'=>$form->createView()
            ));    }

    public function voirAction($id)
    {
        $em = $this->getDoctrine()->getManager();
		$seances = array();
		if($id != 0){
			$seance = $em->getRepository('ABReservationZenithBundle:Seance')->findOneById($id);
			array_push($seances,$seance);
		}else{
			$seances = $em->getRepository('ABReservationZenithBundle:Seance')->findAll();
		}
			
        return $this->render('ABReservationZenithBundle:Seance:voir.html.twig', array(
        'seances'=>$seances
            ));    }

    public function supprimerAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $seance = $em->getRepository('ABReservationZenithBundle:Seance')->findOneById($id);
        $em->remove($seance);
        $em->flush();
        $seances = $em->getRepository('ABReservationZenithBundle:Seance')->findAll();		
			
        return $this->render('ABReservationZenithBundle:Seance:voir.html.twig', array(
        'seances'=>$seances
            ));    }

}
