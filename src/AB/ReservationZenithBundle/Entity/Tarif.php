<?php

namespace AB\ReservationZenithBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

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
     * @var integer
     *
     * @ORM\Column(name="numeroPlaceMin", type="integer", length=4)
     */
    private $numeroPlaceMin;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="numeroPlaceMax", type="integer", length=4)
     */
    private $numeroPlaceMax;

	/**
     * @ORM\ManyToOne(targetEntity="Spectacle", inversedBy="tarifs")
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
     * Set numeroPlaceMin
     *
     * @param string $numeroPlaceMin
     * @return Tarif
     */
    public function setNumeroPlaceMin($numeroPlaceMin)
    {
        $this->numeroPlaceMin = $numeroPlaceMin;

        return $this;
    }

    /**
     * Get numeroPlaceMin
     *
     * @return string 
     */
    public function getNumeroPlaceMin()
    {
        return $this->numeroPlaceMin;
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
    
    public function __toString(){
		return strval($this->prix);
	}

    /**
     * Set numeroPlaceMax
     *
     * @param integer $numeroPlaceMax
     * @return Tarif
     */
    public function setNumeroPlaceMax($numeroPlaceMax)
    {
        $this->numeroPlaceMax = $numeroPlaceMax;

        return $this;
    }
    //fonction pour placer le champ minimal à la dernière place non attribué
    //faire validator pour que le numéro de la dernière place ne dépasse pas le nombre de place du spectacle
    private function retournerIntervallePlaceNonAttribuee()
    {
		$maxPlaces = 0;
		$em = $this->getEntityManager();
		$queryBuilder = $em->createQueryBuilder()
				->select('t')
				->from($this->_entityName,'t')
				->where('t.spectacle_id = :id')
				->setParameter('id',$this->getSpectacle()->getId());
		$result = $queryBuilder->getQuery()->getResult();
				
		foreach ($result as $res){
			if($res->getNumeroPlaceMax > $maxPlaces){
				$maxPlaces = $res->getNumeroPlaceMax;
			}
			
		}
		return ($maxPlaces+1);
	}

    /**
     * Get numeroPlaceMax
     *
     * @return integer 
     */
    public function getNumeroPlaceMax()
    {
        return $this->numeroPlaceMax;
    }

    
    
     
}
