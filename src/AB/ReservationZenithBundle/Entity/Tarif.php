<?php

namespace AB\ReservationZenithBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Tarif
 *
 * @ORM\Table()
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="AB\ReservationZenithBundle\Entity\TarifRepository")
 */
class Tarif
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
     * @var float
     *
     * @ORM\Column(name="prix", type="float")
     */
    private $prix;

    /**
     * @var string
     *
     * @ORM\Column(name="NumsPlacesConcernees", type="string", length=10)
     */
    private $numsPlacesConcernees;

	/**
     * @ORM\ManyToOne(targetEntity="Spectacle")
     * @ORM\JoinColumn(name="spectacle_id", referencedColumnName="id")
     **/
     private $spectacle;
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
     * Set prix
     *
     * @param float $prix
     * @return Tarif
     */
    public function setPrix($prix)
    {
        $this->prix = $prix;

        return $this;
    }

    /**
     * Get prix
     *
     * @return float 
     */
    public function getPrix()
    {
        return $this->prix;
    }

    /**
     * Set numsPlacesConcernees
     *
     * @param string $numsPlacesConcernees
     * @return Tarif
     */
    public function setNumsPlacesConcernees($numsPlacesConcernees)
    {
        $this->numsPlacesConcernees = $numsPlacesConcernees;

        return $this;
    }

    /**
     * Get numsPlacesConcernees
     *
     * @return string 
     */
    public function getNumsPlacesConcernees()
    {
        return $this->numsPlacesConcernees;
    }

    /**
     * Set spectacle
     *
     * @param \AB\ReservationZenithBundle\Entity\Spectacle $spectacle
     * @return Tarif
     */
    public function setSpectacle(\AB\ReservationZenithBundle\Entity\Spectacle $spectacle = null)
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
}
