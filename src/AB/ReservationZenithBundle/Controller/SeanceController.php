<?php

namespace AB\ReservationZenithBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AB\ReservationZenithBundle\Form\SeanceType;
use AB\ReservationZenithBundle\Entity\Seance;
use AB\ReservationZenithBundle\Entity\Spectacle;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Symfony\Component\Validator\ExecutionContextInterface;

class SeanceController extends Controller
{
    public function indexAction()
    {
		
        return $this->render('ABReservationZenithBundle:Seance:index.html.twig', array(
                // ...
            ));    }

/**
* @Secure(roles="ROLE_ADMIN")
*/
    public function ajouterAction()
    {
		$em = $this->getDoctrine()->getManager();
		$form = $this->createForm(new SeanceType(), new Seance());		
        return $this->render('ABReservationZenithBundle:Seance:ajouter.html.twig', array(
                'form'=>$form->createView()
            ));    }

/**
* @Secure(roles="ROLE_ADMIN")
*/
    public function modifierAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $seance = $em->getRepository('ABReservationZenithBundle:Seance')->findOneById($id);
		$form = $this->createForm(new SeanceType(), $seance);
		$form->handleRequest($this->getRequest());
		if($form->isValid()){
			$seance = $form->getData();
			$em->persist($seance);
			$em->flush();
			$id = $seance->getId();
			return $this->redirect($this->get('router')->generate('voir_seance',array('id'=>$id)));
		}
        return $this->render('ABReservationZenithBundle:Seance:modifier.html.twig', array(
        'form'=>$form->createView()
            ));    }


    public function voirAction($id_spectacle,$id)
    {
        $em = $this->getDoctrine()->getManager();
		$seances = array();
        if($id_spectacle != 0)
        {
           
            $spectacle = $em->getRepository('ABReservationZenithBundle:Spectacle')->findOneById($id_spectacle);
            if(!$spectacle){
                throw $this->createNotFoundException('Spectacle inexistant avec l\' id :'.$id_spectacle.$spectacle);
            }
            $seances = $em->getRepository('ABReservationZenithBundle:Seance')->findBySpectacle($spectacle);
            if($id != 0)
            {
                
                foreach($seances as $e)
                {
                    if($e->id == $id)
                    {
                        $seance = $e;
                    }

                }
                if($seance)
                {
                    $seances = array();
                    array_push($seances,$seance);               }
            }
        }else{
    		if($id != 0){
    			$seance = $em->getRepository('ABReservationZenithBundle:Seance')->findOneById($id);
    			array_push($seances,$seance);
    		}else{
    			$seances = $em->getRepository('ABReservationZenithBundle:Seance')->findAll();
    		}
        }
			
        return $this->render('ABReservationZenithBundle:Seance:voir.html.twig', array(
        'seances'=>$seances
            ));    
    }

/**
* @Secure(roles="ROLE_ADMIN")
*/
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
