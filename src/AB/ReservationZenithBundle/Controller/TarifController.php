<?php

namespace AB\ReservationZenithBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AB\ReservationZenithBundle\Form\TarifType;
use AB\ReservationZenithBundle\Entity\Tarif;

class TarifController extends Controller
{
    public function indexAction()
    {
        return $this->render('ABReservationZenithBundle:Tarif:index.html.twig', array(
                // ...
            ));    }

    public function ajouterAction()
    {
        $em = $this->getDoctrine()->getManager();
		$form = $this->createForm(new TarifType(), new Tarif());
		$form->handleRequest($this->getRequest());
		if($form->isValid()){
			$tarif = $form->getData();
			$em->persist($tarif);
			$em->flush($tarif);
			$id = $tarif->getId();
			return $this->redirect($this->get('router')->generate('voir_tarif',array('id'=>$id)));
		}
        return $this->render('ABReservationZenithBundle:Tarif:ajouter.html.twig', array(
        'form'=>$form->createView()
            ));   }

    public function voirAction($id)
    {
        $em = $this->getDoctrine()->getManager();
		$tarifs = array();
		if($id != 0){
			$tarif = $em->getRepository('ABReservationZenithBundle:Tarif')->findOneById($id);
			array_push($tarifs,$tarif);
		}else{
			$tarifs = $em->getRepository('ABReservationZenithBundle:Tarif')->findAll();
		}
			
        return $this->render('ABReservationZenithBundle:Tarif:voir.html.twig', array(
        'tarifs'=>$tarifs
            ));     }

    public function modifierAction($id)
    {
		$em = $this->getDoctrine()->getManager();
        $tarif = $em->getRepository('ABReservationZenithBundle:Tarif')->findOneById($id);
		$form = $this->createForm(new TarifType(), $tarif);
		$form->handleRequest($this->getRequest());
		if($form->isValid()){
			$tarif = $form->getData();
			$em->persist($tarif);
			$em->flush();
			$id = $tarif->getId();
			return $this->redirect($this->get('router')->generate('voir_tarif',array('id'=>0)));
		}
        return $this->render('ABReservationZenithBundle:Tarif:modifier.html.twig', array(
        'form'=>$form->createView()
            ));    }

    public function supprimerAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $tarif = $em->getRepository('ABReservationZenithBundle:Tarif')->findOneById($id);
        $em->remove($tarif);
        $em->flush();
        $tarifs = $em->getRepository('ABReservationZenithBundle:Tarif')->findAll();		
			
        return $this->render('ABReservationZenithBundle:Tarif:voir.html.twig', array(
        'tarifs'=>$tarifs
            ));    }

}
