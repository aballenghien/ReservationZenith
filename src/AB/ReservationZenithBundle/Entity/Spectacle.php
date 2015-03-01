<?php

namespace AB\ReservationZenithBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Spectacle
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AB\ReservationZenithBundle\Entity\SpectacleRepository")
 */
class Spectacle
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
     * @ORM\Column(name="titre", type="string", length=50)
     */
    private $titre;
    
    /**
     * @var string
     *
     * @ORM\Column(name="genre", type="string", length=50)
     */
    private $genre;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="duree", type="integer", length=3)
     */
    private $duree;
    
	/**
     * @var integer
     *
     * @ORM\Column(name="nombreDePlaces", type="integer")
     */
    private $nombreDePlaces;
    
    /**
     * @ORM\OneToMany(targetEntity="Seance",mappedBy="spectacle", cascade={"persist"})
     **/
     private $seances;
     
     /**
     * @ORM\OneToMany(targetEntity="Tarif",mappedBy="spectacle", cascade={"persist"})
     **/
     private $tarifs;



	public function __construct()
	{
		$this->tarifs = new ArrayCollection();
		$this->seances = new ArrayCollection();
	}
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
     * Set titre
     *
     * @param string $titre
     * @return Spectacle
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;

        return $this;
    }

    /**
     * Get titre
     *
     * @return string 
     */
    public function getTitre()
    {
        return $this->titre;
    }
    
    public function __toString(){
		return $this->titre;
	}

    /**
     * Set genre
     *
     * @param string $genre
     * @return Spectacle
     */
    public function setGenre($genre)
    {
        $this->genre = $genre;

        return $this;
    }

    /**
     * Get genre
     *
     * @return string 
     */
    public function getGenre()
    {
        return $this->genre;
    }

    /**
     * Set duree
     *
     * @param integer $duree
     * @return Spectacle
     */
    public function setDuree($duree)
    {
        $this->duree = $duree;

        return $this;
    }

    /**
     * Get duree
     *
     * @return integer 
     */
    public function getDuree()
    {
        return $this->duree;
    }

    /**
     * Set nombreDePlaces
     *
     * @param integer $nombreDePlaces
     * @return Spectacle
     */
    public function setNombreDePlaces($nombreDePlaces)
    {
        $this->nombreDePlaces = $nombreDePlaces;

        return $this;
    }

    /**
     * Get nombreDePlaces
     *
     * @return integer 
     */
    public function getNombreDePlaces()
    {
        return $this->nombreDePlaces;
    }
    
    /**
     * Set tarifs
     *
     * @param ArrayCollection $tarifs
     * @return Spectacle
     */
    public function setTarifs(ArrayCollection $tarifs)
    {
        foreach($tarifs as $tarif){
            $tarif->setSpectacle($this);
        }
        $this->tarifs = $tarifs;

        return $this;
    }

    /**
     * Get tarifs
     *
     * @return ArrayCollection 
     */
    public function getTarifs()
    {
        return $this->tarifs;
    }
    
    /**
     * Set seances
     *
     * @param ArrayCollection $seances
     * @return Spectacle
     */
    public function setSeances(ArrayCollection $seances)
    {
        foreach($seances as $seance){
            $seance->setSpectacle($this);
        }
        $this->seances = $seances;

        return $this;
    }

    /**
     * Get seances
     *
     * @return ArrayCollection 
     */
    public function getSeances()
    {
        return $this->seances;
    }
}
