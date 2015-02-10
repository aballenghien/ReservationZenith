<?php

namespace AB\ReservationZenithBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AB\ReservationZenithBundle\Form\SpectacleType;
use AB\ReservationZenithBundle\Entity\Spectacle;

class SpectacleController extends Controller
{
    public function indexAction()
    {
        return $this->render('ABReservationZenithBundle:Spectacle:index.html.twig', array(
                // ...
            ));    }

    public function ajouterAction()
    {
		$em = $this->getDoctrine()->getManager();
		$form = $this->createForm(new SpectacleType(), new Spectacle());
		$form->handleRequest($this->getRequest());
		if($form->isValid()){
			$spectacle = $form->getData();
			$em->persist($spectacle);
			$em->flush($spectacle);
			$id = $spectacle->getId();
			return $this->redirect($this->get('router')->generate('voir_spectacle',array('id'=>$id)));
		}
        return $this->render('ABReservationZenithBundle:Spectacle:ajouter.html.twig', array(
        'form'=>$form->createView()
            ));
	}
            

    public function voirAction($id)
    {
		$em = $this->getDoctrine()->getManager();
		$spectacles = array();
		if($id != 0){
			$spectacle = $em->getRepository('ABReservationZenithBundle:Spectacle')->findOneById($id);
			array_push($spectacles,$spectacle);
		}else{
			$spectacles = $em->getRepository('ABReservationZenithBundle:Spectacle')->findAll();
		}
			
        return $this->render('ABReservationZenithBundle:Spectacle:voir.html.twig', array(
        'spectacles'=>$spectacles
            ));    
	}

    public function modifierAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $spectacle = $em->getRepository('ABReservationZenithBundle:Spectacle')->findOneById($id);
		$form = $this->createForm(new SpectacleType(), $spectacle);
		$form->handleRequest($this->getRequest());
		if($form->isValid()){
			$spectacle = $form->getData();
			$em->persist($spectacle);
			$em->flush($spectacle);
			$id = $spectacle->getId();
			return $this->redirect($this->get('router')->generate('voir',array('id'=>0)));
		}
        return $this->render('ABReservationZenithBundle:Spectacle:modifier.html.twig', array(
        'form'=>$form->createView()
            ));
	}
	public function supprimerAction($id)
    {
		$em = $this->getDoctrine()->getManager();
        $spectacle = $em->getRepository('ABReservationZenithBundle:Spectacle')->findOneById($id);
        $em->remove($spectacle);
        $em->flush();
        $spectacles = $em->getRepository('ABReservationZenithBundle:Spectacle')->findAll();		
			
        return $this->render('ABReservationZenithBundle:Spectacle:voir.html.twig', array(
        'spectacles'=>$spectacles
            ));
    }

}
