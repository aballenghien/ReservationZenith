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
use Symfony\Component\Validator\ExecutionContextInterface;


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
    public function ajouterAction(Request $request, ExecutionContextInterface $context = null)
    {
		$em = $this->getDoctrine()->getManager();
		$form = $this->createForm(new SpectacleType(),new Spectacle());
		
		if($request->isMethod('POST')){
			$form->handleRequest($this->getRequest());			
			if($form->isValid()){
				$spectacle = $form->getData();
				$ok = true;
				foreach($spectacle->getSeances() as $se){
					if($ok){
						$ok = $em->getRepository('ABReservationZenithBundle:Seance')->isLibre($se);
					}
				}
				if($ok){
					$em->persist($spectacle);
					$em->flush();
					$id = $spectacle->getId();
					ExecuterLesCommandes::runCommand('reservationzenith:genererRSS',$this);
					return $this->redirect($this->get('router')->generate('voir_spectacle',array('id'=>$id)));
				}else{
					$context->addViolationAt(
            		'seances',
            		'erreur.seances.erreurGenerale');
				}
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
				$ok = true;
				foreach ($originalsSeances as $seance ) {
					if(($spectacle->getSeances()->contains($seance)) == false)
					{																			
						$em->remove($seance);
						$em->flush();

					}else{
						if($ok){
							$ok = $em->getRepository('ABReservationZenithBundle:Seance')->isLibre($seance);
						}
						if($ok) $em->persist($seance);
					}
				}
				foreach ($originalsTarifs as $tarif) {
					if(($spectacle->getTarifs()->contains($tarif)) == false)
					{
						$em->remove($tarif);
						$em->flush();
					}else{
						$em->persist($tarif);
					}
				}
				if($ok){
					$em->persist($spectacle);
					$em->flush();
					ExecuterLesCommandes::runCommand('reservationzenith:genererRSS',$this);
					$id = $spectacle->getId();
					return $this->redirect($this->get('router')->generate('voir_spectacle',array('id'=>$id)));
				}
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
        foreach ($spectacle->getSeances() as $se) {
        	$reservations = $em->getRepository('ABReservationZenithBundle:Reservation')->findBy(array('seance' => $se->getId() ));
        	foreach($reservations as $re){
        		$em->remove($re);
        		$em->flush();
        	}
        	$em->remove($se);
        	$em->flush();
        }

        foreach ($spectacle->getTarifs() as $ta) {
        	$em->remove($ta);
        	$em->flush();
        }
        $em->remove($spectacle);
        $em->flush();		
		ExecuterLesCommandes::runCommand('reservationzenith:genererRSS',$this);
        return $this->redirect($this->get('router')->generate('voir_spectacle'));
    }



}
