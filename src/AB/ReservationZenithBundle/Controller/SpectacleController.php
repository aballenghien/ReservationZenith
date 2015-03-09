<?php

namespace AB\ReservationZenithBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AB\ReservationZenithBundle\Form\SpectacleType;
use AB\ReservationZenithBundle\Entity\Spectacle;
use AB\ReservationZenithBundle\Entity\Seance;
use AB\ReservationZenithBundle\Entity\Tarif;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Collections\ArrayCollection;
use JMS\SecurityExtraBundle\Annotation\Secure;
use AB\ReservationZenithBundle\Command\ExecuterLesCommandes;

class SpectacleController extends Controller
{
    public function indexAction()
    {
        return $this->render('ABReservationZenithBundle:Spectacle:index.html.twig', array(
                // ...
            ));    }

/**
* @Secure(roles="ROLE_ADMIN")
*/
    public function ajouterAction(Request $request)
    {
		$em = $this->getDoctrine()->getManager();
		$form = $this->createForm(new SpectacleType(),new Spectacle());
		
		if($request->isMethod('POST')){
			$form->handleRequest($this->getRequest());			
			
			if($form->isValid()){
				$spectacle = $form->getData();
				$em->persist($spectacle);
				$em->flush();
				$id = $spectacle->getId();
				ExecuterLesCommandes::runCommand('reservationzenith:genererRSS',$this);
				return $this->redirect($this->get('router')->generate('voir_spectacle',array('id'=>$id)));
			}
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
			return $this->render('ABReservationZenithBundle:Spectacle:details.html.twig', array(
        'spectacle'=>$spectacle
            ));   
		}else{
			$spectacles = $em->getRepository('ABReservationZenithBundle:Spectacle')->findAll();
			 return $this->render('ABReservationZenithBundle:Spectacle:voir.html.twig', array(
        'spectacles'=>$spectacles
            ));
		}
			
           
	}
/**
* @Secure(roles="ROLE_ADMIN")
*/
    public function modifierAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $spectacle = $em->getRepository('ABReservationZenithBundle:Spectacle')->find($id);
        if(!$spectacle){
        	throw $this->createNotFoundException('Aucun spectacle trouvé pour cet id');
        }
        $originalsTarifs = new ArrayCollection();
        $originalsSeances = new ArrayCollection();
        foreach ($spectacle->getTarifs() as $tarif) {
        	$originalsTarifs->add($tarif);
    	}

    	foreach ($spectacle->getSeances() as $seance) {
        	$originalsSeances->add($seance);
    	}

		$form = $this->createForm(new SpectacleType(), $spectacle);
		if($request->isMethod('POST')){
			$form->handleRequest($this->getRequest());
			if($form->isValid()){
				foreach ($originalsSeances as $seance ) {
					if(($spectacle->getSeances()->contains($seance)) == false)
					{	
																		
						$em->remove($seance);
						$em->flush();

					}
				}
				foreach ($originalsTarifs as $tarif) {
					if(($spectacle->getTarifs()->contains($tarif)) == false)
					{
						$em->remove($tarif);
						$em->flush();
					}
				}
				$em->persist($spectacle);
				$em->flush($spectacle);
				ExecuterLesCommandes::runCommand('reservationzenith:genererRSS',$this);
				$id = $spectacle->getId();
				return $this->redirect($this->get('router')->generate('voir_spectacle',array('id'=>$id)));
			}
		}
        return $this->render('ABReservationZenithBundle:Spectacle:modifier.html.twig', array(
        'form'=>$form->createView()
            ));
	}

/**
* @Secure(roles="ROLE_ADMIN")
*/
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
