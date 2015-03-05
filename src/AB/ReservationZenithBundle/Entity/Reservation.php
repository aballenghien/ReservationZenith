<?php

namespace AB\ReservationZenithBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AB\ConnexionBundle\Entity;
/**
 * Reservation
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AB\ReservationZenithBundle\Entity\ReservationRepository")
 */
class Reservation
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
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=50)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="prenom", type="string", length=50)
     */
    private $prenom;

    /**
     * @var integer
     *
     * @ORM\Column(name="place", type="integer")
     */
    private $place;

	/**
     * @ORM\ManyToOne(targetEntity="Seance")
     * @ORM\JoinColumn(name="seance_id", referencedColumnName="id")
     **/
     private $seance;
     
     /**
     * @ORM\ManyToOne(targetEntity="Tarif")
     * @ORM\JoinColumn(name="tarif_id", referencedColumnName="id")
     **/
     private $tarif;
    /**
     * @ORM\ManyToOne(targetEntity="AB\ConnexionBundle\Entity\User")
     * @ORM\JoinColumn(name="client_id", referencedColumnName="id")
     **/
     private $idClientConcerne;

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
     * Set nom
     *
     * @param string $nom
     * @return Reservation
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string 
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set prenom
     *
     * @param string $prenom
     * @return Reservation
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * Get prenom
     *
     * @return string 
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * Set place
     *
     * @param integer $place
     * @return Reservation
     */
    public function setPlace($place)
    {
        $this->place = $place;

        return $this;
    }

    /**
     * Get place
     *
     * @return integer 
     */
    public function getPlace()
    {
        return $this->place;
    }

    /**
     * Set seance
     *
     * @param \AB\ReservationZenithBundle\Entity\Seance $seance
     * @return Reservation
     */
    public function setSeance(\AB\ReservationZenithBundle\Entity\Seance $seance = null)
    {
        $this->seance = $seance;

        return $this;
    }

    /**
     * Get seance
     *
     * @return \AB\ReservationZenithBundle\Entity\Seance 
     */
    public function getSeance()
    {
        return $this->seance;
    }

    /**
     * Set tarif
     *
     * @param \AB\ReservationZenithBundle\Entity\Tarif $tarif
     * @return Reservation
     */
    public function setTarif(\AB\ReservationZenithBundle\Entity\Tarif $tarif = null)
    {
        $this->tarif = $tarif;

        return $this;
    }

    /**
     * Get tarif
     *
     * @return \AB\ReservationZenithBundle\Entity\Tarif 
     */
    public function getTarif()
    {
        return $this->tarif;
    }

    /**
     * Set idClientConcerne
     *
     * @param \AB\ReservationZenithBundle\Entity\User $idClientConcerne
     * @return Reservation
     */
    public function setIdClientConcerne(\AB\ConnexionBundle\Entity\User $idClientConcerne = null)
    {
        $this->idClientConcerne = $idClientConcerne;

        return $this;
    }

    /**
     * Get idClientConcerne
     *
     * @return \AB\ReservationZenithBundle\Entity\User 
     */
    public function getIdClientConcerne()
    {
        return $this->idClientConcerne;
    }
}
