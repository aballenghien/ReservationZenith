<?php

namespace AB\ReservationZenithBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\ExecutionContextInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Seance
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AB\ReservationZenithBundle\Entity\SeanceRepository")
 * @Assert\Callback(methods={"isValid"})
 */
class Seance
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="heure", type="time")
     */
    private $heure;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date")
     */
    private $date;

    

    /**
     * @var integer
     *
     * @ORM\Column(name="nombrePlacesRestantes", type="integer")
     */
    private $nombrePlacesRestantes;
	
	/**
     * @ORM\ManyToOne(targetEntity="Spectacle", inversedBy="seances")
     * @ORM\JoinColumn(name="spectacle_id", referencedColumnName="id")
     **/
	private $spectacle;

     /**
     * @ORM\OneToMany(targetEntity="Reservation",mappedBy="seance", cascade={"remove"})
     **/
     private $seances;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set heure
     *
     * @param \DateTime $heure
     * @return Seance
     */
    public function setHeure($heure)
    {
        $this->heure = $heure;

        return $this;
    }

    /**
     * Get heure
     *
     * @return \DateTime 
     */
    public function getHeure()
    {
        return $this->heure;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return Seance
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime 
     */
    public function getDate()
    {
        return $this->date;
    }

    

    /**
     * Set nombrePlacesRestantes
     *
     * @param integer $nombrePlacesRestantes
     * @return Seance
     */
    public function setNombrePlacesRestantes($nombrePlacesRestantes)
    {
        $this->nombrePlacesRestantes = $nombrePlacesRestantes;

        return $this;
    }



    /**
     * Get nombrePlacesRestantes
     *
     * @return integer 
     */
    public function getNombrePlacesRestantes()
    {
        return $this->nombrePlacesRestantes;
    }

    /**
     * Set spectacle
     *
     * @param \AB\ReservationZenithBundle\Entity\Spectacle $spectacle
     * @return Seance
     */
    public function setSpectacle(\AB\ReservationZenithBundle\Entity\Spectacle $spectacle)
    {
        $this->spectacle = $spectacle;

        return $this;
    }

    /**
     * Get spectacle
     *
     * @return \AB\ReservationZenithBundle\Entity\Spectacle 
     */
    public function getSpectacle()
    {
        return $this->spectacle;
    }
    
    public function __toString (){
        $titre = "";
        if($this->getSpectacle()!=null){
		  $titre = $this->getSpectacle()->getTitre();
        }
        return $titre.": ".$this->getHeure()->format('H:i');;
	}

    public function isValid(ExecutionContextInterface $context)
    {

        if ($this->getNombrePlacesRestantes()> $this->getSpectacle()->getNombreDePlaces()) {
            $context->addViolationAt(
                'nombrePlacesRestantes',
                'erreur.seance.nombrePlacesRestantes');
        }

        if(!$this->isLibre($this->getHeure())){
            $context->addViolationAt(
                'heure',
                'erreur.seance.salleOccupee');
        }

    }
}
