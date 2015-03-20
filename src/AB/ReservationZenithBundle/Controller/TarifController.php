<?php

namespace AB\ReservationZenithBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AB\ReservationZenithBundle\Form\TarifType;
use AB\ReservationZenithBundle\Entity\Tarif;
use AB\ReservationZenithBundle\Entity\Spectacle;
use JMS\SecurityExtraBundle\Annotation\Secure;

class TarifController extends Controller
{
    public function indexAction()
    {
        return $this->render('ABReservationZenithBundle:Tarif:index.html.twig', array(
                // ...
            ));    }
/**
* @Secure(roles="ROLE_ADMIN")
*/
    public function ajouterAction()
    {
        
		$form = $this->createForm(new TarifType(), new Tarif());		
        return $this->render('ABReservationZenithBundle:Tarif:ajouter.html.twig', array(
        'form'=>$form->createView()
            ));   
    }


    public function voirAction($id,$id_spectacle)
    {
        $em = $this->getDoctrine()->getManager();
		$tarifs = array();
		if($id_spectacle != 0)
        {
            $spectacle = $em->getRepository('ABReservationZenithBundle:Spectacle')->findOneById($id_spectacle);
            if(!$spectacle){
                throw $this->createNotFoundException('Spectacle inexistant avec l\' id :'.$id_spectacle.$spectacle);
            }
            $tarifs = $em->getRepository('ABReservationZenithBundle:Tarif')->findBySpectacle($spectacle);
            if($id != 0)
            {
                foreach($tarifs as $e)
                {
                    if($e->id == $id)
                    {
                        $tarif = $e;
                    }

                }
                if($tarif)
                {
                    $tarifs = array();
                    array_push($tarifs,$tarif);               }
            }
        }else{
            if($id != 0){
                $tarif = $em->getRepository('ABReservationZenithBundle:Tarif')->findOneById($id);
                array_push($tarifs,$tarif);
            }else{
                $tarifs = $em->getRepository('ABReservationZenithBundle:Tarif')->findAll();
            }
        }
			
        return $this->render('ABReservationZenithBundle:Tarif:voir.html.twig', array(
        'tarifs'=>$tarifs
            ));     }

/**
* @Secure(roles="ROLE_ADMIN")
*/
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
        
/**
* @Secure(roles="ROLE_ADMIN")
*/
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
